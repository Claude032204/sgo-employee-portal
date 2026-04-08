<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('SGO Portal - Verify Your Email')
            ->greeting('Hello ' . ($notifiable->first_name ?? 'Employee') . '!')
            ->line('Welcome to the SGO Employee Portal.')
            ->line('Here are your account details:')
            ->line('Login ID: ' . ($notifiable->login_id ?? 'N/A'))
            ->line('Email: ' . ($notifiable->email ?? 'N/A'))
            ->line('Please verify your email address to activate your account.')
            ->action('Verify Email', $verificationUrl)
            ->line('If you did not expect this email, please ignore it.')
            ->salutation('— SGO Portal HR Team');
    }
}