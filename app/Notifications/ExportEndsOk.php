<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportEndsOk extends Notification
{
    use Queueable;

    private string $fileName;
    private string $export;
    private string $message;

    /**
     * Create a new notification instance.
     *
     * @param string $fileName
     * @param string $export
     * @param string $message
     */
    public function __construct(string $fileName, string $export, string $message)
    {
        $this->fileName = $fileName;
        $this->export = $export;
        $this->message = $message;
    }

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
        return (new MailMessage())
                    ->attach(storage_path('app/public/exports/') . $this->fileName)
                    ->subject($this->export)
                    ->line($this->message)
                    ->action(trans('actions.download'), asset('/exports/' . $this->fileName))
                    ->line(trans('messages.bye'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
