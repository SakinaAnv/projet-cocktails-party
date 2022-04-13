<?php

namespace App\Events;

use App\Entity\Cocktail;
use Symfony\Contracts\EventDispatcher\Event;

class AddCocktailEvent extends  Event
{
    const ADD_COCKTAIL_EVENT = 'cocktail.add';

    public function __construct(private Cocktail $cocktail) {}

    public function getCocktail(): Cocktail {
        return $this->cocktail;
    }
}