<?php

namespace App\EventSubscriber;

use App\Events\AddUserEvent;
use App\Services\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private MailerService $mailer) {}

    public static function getSubscribedEvents(): array
    {
        return [
            AddUserEvent::ADD_USER_EVENT => ['onAddUserEvent']
        ];
    }

    public function onAddUserEvent(AddUserEvent $event) {
        $user = $event->getUser();
        $mailMessage = $user->getFirstname().' '.$user->getName()." a été ajouté avec succès";
        $this->mailer->sendEmail(content: $mailMessage, subject: 'Mail sent from EventSubscriber');
    }
}