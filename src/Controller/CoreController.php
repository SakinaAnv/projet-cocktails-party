<?php

namespace App\Controller;

use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoreController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('core/index.html.twig');
    }

    #[Route('/listeCocktails', name: 'listeCocktails')]
    public function listeCocktails(CocktailRepository $cocktailRepository): Response
    {
        return $this->render('core/liste.html.twig', [
            'cocktail' => $cocktailRepository->findAll()
        ]);
    }

}
