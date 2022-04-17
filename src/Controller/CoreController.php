<?php

namespace App\Controller;

use App\Repository\CocktailRepository;
use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CoreController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(TableRepository $tableRepository): Response
    {
        return $this->render('core/index.html.twig',
        ['tables'=> $tableRepository->findByTableAvailable('1') ]);
    }

    #[Route('/listeCocktails/{id?null}', name: 'listeCocktails')]
    public function listeCocktails(SessionInterface $session,CocktailRepository $cocktailRepository,$id): Response
    {
         $session->set("table", $id);
        return $this->render('core/liste.html.twig', [
            'cocktail' => $cocktailRepository->findAll()
        ]);
    }

}
