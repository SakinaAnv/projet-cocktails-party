<?php

namespace App\EventListener;

use App\Events\AddIngredientEvent;
use App\Services\MailerService;

class IngredientListener
{

    public function __construct(private MailerService $mailer) {}

    public function onAddIngredientEvent(AddIngredientEvent $event) {
        $ingredient = $event->getIngredient();
        $mailMessage = $ingredient->getName()." est un nouvel ingredient";
        $this->mailer->sendEmail(content: $mailMessage, subject: 'Un nouvel ingrédient a été ajouté');
    }

}