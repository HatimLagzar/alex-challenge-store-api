<?php

namespace App\Services\Domain\Contact;

use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;

class ContactUsService
{
    public function send(string $name, string $email, string $subject, string $message): bool
    {
        $subject = $name . ' || ' . $email . ' || ' . $subject;

        Mail::to(env('MAIL_FROM_ADDRESS'))
            ->send(new ContactUsMail($name, $email, $subject, $message));

        return true;
    }
}