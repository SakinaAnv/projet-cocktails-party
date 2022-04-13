<?php

namespace App\Events;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use Symfony\Contracts\EventDispatcher\Event;

class AddIngredientEvent extends Event
{

    const ADD_COCKTAIL_EVENT = 'cocktail.add';

    public function __construct(private Ingredient $ingredient) {}

    public function getCocktail(): Ingredient {
        return $this->ingredient;
    }
}