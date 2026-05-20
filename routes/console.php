<?php

# routes/console.php
# Jalankan via terminal: php artisan send-mail

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('send-mail', function () {
    $this->info('Sedang mencoba mengirim email nyata via Brevo SMTP...');

    try {
        // Menggunakan Mail Facade bawaan Laravel (Otomatis membaca setingan .env Brevo)
        Mail::raw('Congrats! Fitur pengiriman email asli via Brevo SMTP gratis sudah berjalan 100% pada sistem SiEval DSS Bojongsoang.', function ($message) {
            $message->to('naufalrahmat356@gmail.com')
                    ->subject('You are awesome! (Brevo SMTP Testing)');
        });

        $this->info('🚀 Email nyata berhasil meluncur langsung ke Gmail kamu via Brevo!');
        
    } catch (\Exception $e) {
        $this->error('❌ Gagal mengirim email: ' . $e->getMessage());
    }

})->purpose('Send Real Mail via Brevo SMTP');