<?php

namespace App\Notifications;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNewBookingNotification extends Notification
{
    use Queueable;

    // Add a public property to hold the transaction data
    public Transaction $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction)
    {
        // Accept the newly created transaction object
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // We are only sending this via email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Construct the direct URL to the edit page in your Filament admin panel
        $url = TransactionResource::getUrl('edit', ['record' => $this->transaction->id]);

        return (new MailMessage)
                    ->subject('New Booking Received: ' . $this->transaction->trx_id)
                    ->greeting('Hello Admin,')
                    ->line('A new booking has been created and requires your attention.')
                    ->line('Booking ID: ' . $this->transaction->trx_id)
                    ->line('Tenant Name: ' . $this->transaction->name)
                    ->action('View Booking in Admin Panel', $url) // This creates a button in the email
                    ->line('Thank you for your attention.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}