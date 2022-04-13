<?php

namespace App\EventListener;

use App\Events\AddUserEvent;
use Psr\Log\LoggerInterface;

class UserListener
{
    public function __construct(private LoggerInterface $logger) {
    }
    public function onPersonneAdd(AddUserEvent $event){
        $this->logger->debug("cc je suis entrain d'écouter l'evenement personne.add et une personne vient d'être ajoutée et c'est ". $event->getPersonne()->getName());
    }

}