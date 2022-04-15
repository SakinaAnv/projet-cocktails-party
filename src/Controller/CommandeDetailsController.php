<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\ConfirmOrderFormType;
use App\Repository\CocktailRepository;
use App\Repository\DetailCommandeRepository;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Framework\RequestConfig;

/**
 * Class CommandeDetailsController
 * @package App\Controller
 * @Route("/commandes", name="commandes_")
 */

class CommandeDetailsController extends AbstractController
{

    private $detailCommandeRepository;
    private $cocktailRepository;

    public function __construct(DetailCommandeRepository $detailCommandeRepository, CocktailRepository $cocktailRepository)
    {
        $this->detailCommandeRepository = $detailCommandeRepository;
        $this->cocktailRepository = $cocktailRepository;
    }


    #[Route('/{slug}', name: 'commande')]
    public function index($slug): Response
    {

        $details = $this->detailCommandeRepository->findByNumCommande(array('numCommande' => $slug));
        $boisson = $this->cocktailRepository->findByName(array('name' => $slug));

        return $this->render('commande_details/index.html.twig', [
            'details' => $details,
            'boisson' => $boisson,
        ]);

    }
}