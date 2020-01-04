<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
use Dingo\Api\Facade\API;

class ResetPasswordNotification extends ResetPassword
{

   
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')

 ->action(Lang::get('Reset Password'), url(config('app.url'). app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                    ->line('Thank you for using our application!');
    }

}
