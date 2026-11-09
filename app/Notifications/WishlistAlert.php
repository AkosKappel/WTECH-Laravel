<?php

namespace App\Notifications;

use App\Models\Smartphone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Tells a customer that a phone on their wishlist is back in stock or got cheaper.
 * Holds plain values instead of the model, so it reports the phone as it was when it changed.
 */
class WishlistAlert extends Notification implements ShouldQueue
{
    use Queueable;

    const BACK_IN_STOCK = 'back_in_stock';
    const PRICE_DROP = 'price_drop';

    private array $data;

    public function __construct(Smartphone $smartphone, string $reason, float $oldPrice)
    {
        $this->data = [
            'reason' => $reason,
            'smartphone' => $smartphone->getRouteKey(),
            'name' => $smartphone->name,
            'price' => $smartphone->current_price,
            'old_price' => $oldPrice,
        ];
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable): array
    {
        return $this->data;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(self::message($this->data))
            ->line(self::message($this->data))
            ->action(__('View phone'), route('details', $this->data['smartphone']));
    }

    /**
     * The alert as one sentence in the current language; also used by the notifications page.
     */
    public static function message(array $data): string
    {
        $replace = ['name' => $data['name'], 'price' => formattedPrice($data['price']), 'old_price' => formattedPrice($data['old_price'])];

        return $data['reason'] === self::BACK_IN_STOCK
            ? __(':name is back in stock for :price.', $replace)
            : __(':name now costs :price instead of :old_price.', $replace);
    }
}
