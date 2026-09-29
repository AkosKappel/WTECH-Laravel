<?php

namespace App\Support;

use InvalidArgumentException;

/**
 * One line of the cart. Plain values only, so a cart can live in the session and in
 * the database as arrays/JSON rather than as serialized objects.
 */
class CartItem
{
    private const KEYS = ['id', 'name', 'price', 'qty', 'max_quantity', 'image_source', 'image_name'];

    public string $rowId;

    public function __construct(
        public int $id,
        public string $name,
        public float $price,
        public int $qty,
        public int $maxQuantity,
        public string $imageSource,
        public string $imageName,
    ) {
        // one line per phone
        $this->rowId = (string) $id;
    }

    public function total(): float
    {
        return round($this->price * $this->qty, 2);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'qty' => $this->qty,
            'max_quantity' => $this->maxQuantity,
            'image_source' => $this->imageSource,
            'image_name' => $this->imageName,
        ];
    }

    public static function fromArray(array $data): self
    {
        foreach (self::KEYS as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException("Cart line without '{$key}'.");
            }
        }

        return new self(
            (int) $data['id'],
            (string) $data['name'],
            (float) $data['price'],
            (int) $data['qty'],
            (int) $data['max_quantity'],
            (string) $data['image_source'],
            (string) $data['image_name'],
        );
    }
}
