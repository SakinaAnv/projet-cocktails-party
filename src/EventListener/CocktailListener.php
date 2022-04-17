<?php

namespace App\EventListener;

use App\Events\AddCocktailEvent;
use App\Services\MailerService;

class CocktailListener
{

    public function __construct(private MailerService $mailer) {}

    public function onAddCocktailEvent(AddCocktailEvent $event) {
        $cocktail = $event->getCocktail();
        $mailMessage = $cocktail->getName()." est un nouvel Cocktail";
        $this->mailer->sendEmail(content: $mailMessage, subject: 'Un nouvel cocktail a été ajouté');
    }
}