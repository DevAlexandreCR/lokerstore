<?php

namespace App\Notifications;

use App\Models\ErrorImport;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportEnds extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $message = new MailMessage();
        $failures = ErrorImport::all();
        $message
            ->subject(trans('Products saved'))
            ->line(trans('Products imported successfully'))
            ->line(trans('Errors: ') . count($failures));
        foreach ($failures as $failure) {
            foreach (json_decode($failure->errors, true, 512, JSON_THROW_ON_ERROR) as $error) {
                $message->line($error);
            }
            ErrorImport::destroy($failure->id);
        }

        return $message
            ->action(trans('View'), route('products.index'))
            ->line(trans('Good bye'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
