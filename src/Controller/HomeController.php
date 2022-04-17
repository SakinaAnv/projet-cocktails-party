<?php

namespace App\Controller;

use App\Repository\CocktailRepository;
use App\Repository\NtableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'bestSellers')]
    public function homepage(CocktailRepository $cocktailRepository): Response
    {
        return $this->render('home/bestSeller.html.twig', [
            'bestSeller' => $cocktailRepository->findAll()
        ]);
    }

    #[Route('/choixTable', name: 'choixTable')]
    public function table(NtableRepository $ntableRepository, CocktailRepository $allproduct): Response
    {
        return $this->render('home/index.html.twig', [
            'table' => $ntableRepository->findAll(),
            'allproduct' => $allproduct,
        ]);
    }

}
