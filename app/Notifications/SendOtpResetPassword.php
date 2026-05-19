<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendOtpResetPassword extends Notification
{
    use Queueable;

    protected $otp;

    // Menerima kode OTP yang di-generate dari controller
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Kode OTP Reset Password - SiEval DSS')
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->line('Berikut adalah kode OTP Anda untuk mengubah password:')
            ->line('**' . $this->otp . '**') // Menampilkan 6 digit OTP tebal
            ->line('Kode OTP ini hanya berlaku selama 60 menit.')
            ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.');
    }
}