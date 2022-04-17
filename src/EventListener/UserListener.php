<?php

namespace App\EventListener;

use App\Events\AddUserEvent;
use App\Services\MailerService;

class UserListener
{

    public function __construct(private MailerService $mailer) {}

    public function onAddUserEvent(AddUserEvent $event) {
        $user = $event->getUser();
        $mailMessage = $user->getFirstname().' '.$user->getName()." est un nouvel utilisateur";
        $this->mailer->sendEmail(content: $mailMessage, subject: 'Nouvel utilisateur dans la famille Cocktail Party');
    }
}