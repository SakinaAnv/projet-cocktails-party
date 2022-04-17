<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CocktailRepository;

class EventController extends AbstractController
{
    #[Route('/listeCocktails', name: 'listeCocktails')]
    public function listeCocktails(CocktailRepository $cocktailRepository): Response
    {
        return $this->render('event/liste.html.twig', [
            'cocktail' => $cocktailRepository->findAll()
        ]);
    }

}