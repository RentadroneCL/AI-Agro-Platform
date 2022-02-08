<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactSupportNotification extends Notification
{
    use Queueable;

    /**
     * Validated data.
     *
     * @var array $data
     */
    protected array $data = [];

    /**
     * Create a new notification instance.
     *
     * @param array $data
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->data['subject'])
                    ->greeting(__('New support ticket'))
                    ->bcc(['alvaro.farias@rentadrone.cl', 'contacto@rentadrone.cl'])
                    ->line(__('Name') . ": {$this->data['name']}")
                    ->line(__('Email') . ": {$this->data['email']}")
                    ->line(__('Contact') . ": {$this->data['phone']}")
                    ->line(__('Reason') . ": {$this->data['type']}")
                    ->line(__('Message') . ": {$this->data['message']}")
                    ->action('Notification Action', url("mailto:{$this->data['email']}"))
                    ->line('Thank you for using our application!');
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
