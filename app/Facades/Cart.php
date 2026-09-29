<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection content()
 * @method static int count()
 * @method static float total()
 * @method static \App\Support\CartItem|null get(string $rowId)
 * @method static int quantityOf(int $productId)
 * @method static \App\Support\CartItem add(\App\Models\Smartphone $smartphone, int $quantity)
 * @method static void update(string $rowId, int $quantity)
 * @method static void remove(string $rowId)
 * @method static void destroy()
 * @method static void fill(\Illuminate\Support\Collection $items)
 * @method static void store(string $identifier)
 * @method static void restore(string $identifier)
 *
 * @see \App\Support\Cart
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Support\Cart::class;
    }
}
