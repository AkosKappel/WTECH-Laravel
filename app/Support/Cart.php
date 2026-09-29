<?php

namespace App\Support;

use App\Models\Smartphone;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * The shopping cart: lines in the session, saved to the database on logout and merged
 * back on login. Carts are stored as JSON; the package used before stored serialize()
 * output, which Postgres cut off at the first NUL byte, so restoring always failed.
 */
class Cart
{
    const SESSION_KEY = 'shop_cart';
    const TABLE = 'shoppingcarts';
    const INSTANCE = 'default';

    /** Session key of hardevine/shoppingcart ('cart.default'), dropped on the next change */
    private const LEGACY_SESSION_KEY = 'cart';

    /**
     * @return Collection<string, CartItem>
     */
    public function content(): Collection
    {
        $items = [];
        foreach ((array) session(self::SESSION_KEY, []) as $data) {
            try {
                $item = CartItem::fromArray((array) $data);
                $items[$item->rowId] = $item;
            } catch (Throwable $e) {
                // an unreadable line is dropped rather than breaking every page
            }
        }

        return collect($items);
    }

    public function count(): int
    {
        return (int) $this->content()->sum('qty');
    }

    public function total(): float
    {
        return round($this->content()->sum(function (CartItem $item) {
            return $item->total();
        }), 2);
    }

    public function get(string $rowId): ?CartItem
    {
        return $this->content()->get($rowId);
    }

    public function quantityOf(int $productId): int
    {
        $item = $this->get((string) $productId);

        return $item ? $item->qty : 0;
    }

    /**
     * Add a phone, or more of it. Name, price and stock always come from the database.
     */
    public function add(Smartphone $smartphone, int $quantity): CartItem
    {
        $content = $this->content();
        $image = $smartphone->images()->first();
        $item = new CartItem(
            $smartphone->id,
            $smartphone->name,
            (float) $smartphone->price,
            $this->quantityOf($smartphone->id) + $quantity,
            (int) $smartphone->quantity,
            $image ? $image->source : 'images/no_img_available.jpg',
            $image ? $image->name : 'No image available',
        );
        $this->fill($content->put($item->rowId, $item));

        return $item;
    }

    public function update(string $rowId, int $quantity): void
    {
        $content = $this->content();
        $item = $content->get($rowId);
        if ($item === null) {
            return;
        }

        if ($quantity <= 0) {
            $content->forget($rowId);
        } else {
            $item->qty = $quantity;
        }
        $this->fill($content);
    }

    public function remove(string $rowId): void
    {
        $this->fill($this->content()->forget($rowId));
    }

    public function destroy(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Replace the cart's lines, e.g. to carry a guest's cart into a fresh session.
     *
     * @param Collection<string, CartItem> $items
     */
    public function fill(Collection $items): void
    {
        session()->forget(self::LEGACY_SESSION_KEY);
        session()->put(self::SESSION_KEY, $items->map(function (CartItem $item) {
            return $item->toArray();
        })->all());
    }

    /**
     * Save the cart for later (on logout), merged into what is already saved, so logging
     * out on a device with an empty or partial cart does not wipe a cart saved elsewhere.
     * The session cart is left as it is.
     */
    public function store(string $identifier): void
    {
        DB::transaction(function () use ($identifier) {
            $stored = $this->storedCart($identifier)->lockForUpdate()->value('content');
            $lines = $this->mergeStored($this->content(), $stored)->map(function (CartItem $item) {
                return $item->toArray();
            })->values()->all();

            $this->storedCart($identifier)->delete();
            if ($lines === []) {
                return;
            }

            DB::table(self::TABLE)->insert([
                'identifier' => $identifier,
                'instance' => self::INSTANCE,
                'content' => json_encode($lines),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    /**
     * Merge the saved cart into the current one (on login): quantities are added up and
     * capped at the current stock, phones that are gone or sold out are dropped, and
     * names and prices are refreshed. The saved cart is deleted afterwards.
     */
    public function restore(string $identifier): void
    {
        $stored = $this->storedCart($identifier)->value('content');
        $this->storedCart($identifier)->delete();
        if ($stored === null) {
            return;
        }

        $this->fill($this->mergeStored($this->content(), $stored));
    }

    /**
     * @param Collection<string, CartItem> $content the current lines
     * @param string|null $stored the saved cart as JSON
     * @return Collection<string, CartItem>
     */
    private function mergeStored(Collection $content, ?string $stored): Collection
    {
        if ($stored === null) {
            return $content;
        }

        $lines = json_decode($stored, true);
        if (!is_array($lines)) {
            Log::warning('Ignored a stored cart that could not be read.');
            return $content;
        }

        $storedItems = collect($lines)->map(function ($data) {
            try {
                return CartItem::fromArray((array) $data);
            } catch (Throwable $e) {
                return null;
            }
        })->filter();
        $phones = Smartphone::whereIn('id', $storedItems->pluck('id'))->get()->keyBy('id');

        foreach ($storedItems as $storedItem) {
            $phone = $phones->get($storedItem->id);
            if ($phone === null || $phone->quantity < 1) {
                continue;
            }

            $current = $content->get($storedItem->rowId);
            $content->put($storedItem->rowId, new CartItem(
                $phone->id,
                $phone->name,
                (float) $phone->price,
                min(($current ? $current->qty : 0) + $storedItem->qty, (int) $phone->quantity),
                (int) $phone->quantity,
                $current ? $current->imageSource : $storedItem->imageSource,
                $current ? $current->imageName : $storedItem->imageName,
            ));
        }

        return $content;
    }

    private function storedCart(string $identifier)
    {
        return DB::table(self::TABLE)->where('identifier', $identifier)->where('instance', self::INSTANCE);
    }
}
