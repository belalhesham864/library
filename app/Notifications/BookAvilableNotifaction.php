<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookAvilableNotifaction extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $book;
    public function __construct($book)
    {
        $this->book=$book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
         ->subject('Book Now Available')
            ->greeting('Hello ' . $notifiable->name)
            ->line('The book "' . $this->book->name . '" is now available for you')
            ->action('View Book',route('books.show',$this->book->id));
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
