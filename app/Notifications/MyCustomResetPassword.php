<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MyCustomResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
            ->subject('MyCook - Recuperação de Senha')
            ->greeting('Ol&aacute;!')
            ->line('Voc&ecirc; est&aacute; recebendo este e-mail porque n&oacute;s recebemos uma requisi&ccedil;&atilde;o para sua conta.')
            ->action('REDEFINIR SENHA', route('password.reset', $this->token))
            ->line('Se voc&ecirc; n&atilde;o requisitou uma redefini&ccedil;&atilde; de senha, nenhuma a&ccedil;&atilde;o &eacute; necess&aacute;ria.')
            ->markdown('vendor.notifications.email');
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
