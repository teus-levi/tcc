<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $url)
    {

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
                    ->markdown('vendor.notifications.email')
                    ->subject('Redefinição de senha')
                    ->greeting('Olá!')
                    ->salutation('Saudações, BabyOn')
                    ->from('babyon@gmail.com')
                    ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.')
                    ->action('Modificar Senha', url($this->url))
                    ->line('Este link de redefinição de senha expirará em 60 minutos.')
                    ->line('Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.');
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
