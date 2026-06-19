<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Order $order
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $orderUrl = route('user.orders.show', $this->order->id);

        return (new MailMessage)
            ->subject('Perubahan Status Pesanan - Rentify')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Status pesanan Anda dengan ID **' . $this->order->id . '** telah berubah menjadi: **' . ucfirst($this->order->status) . '**.')
            ->line('Detail Kendaraan: ' . ($this->order->car->name ?? 'Mobil'))
            ->line('Periode Sewa: ' . ($this->order->start_rent ? $this->order->start_rent->format('d M Y') : '-') . ' s/d ' . ($this->order->end_rent ? $this->order->end_rent->format('d M Y') : '-'))
            ->action('Lihat Detail Pesanan', $orderUrl)
            ->line('Terima kasih telah menggunakan Rentify!');
    }
}
