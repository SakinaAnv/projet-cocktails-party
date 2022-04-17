<?php

namespace App\Events;

use App\Entity\Ingredient;
use Symfony\Contracts\EventDispatcher\Event;

class AddIngredientEvent extends Event
{

    const ADD_Ingredient_EVENT = 'ingredient.add';

    public function __construct(private Ingredient $ingredient) {}

    public function getIngredient(): Ingredient {
        return $this->ingredient;
    }
}