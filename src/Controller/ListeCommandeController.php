<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\ConfirmOrderFormType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListeCommandeController
 * @package App\Controller
 * @Route("/commandes", name="commandes_")
 */
class ListeCommandeController extends AbstractController
{

    private $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository, EntityManagerInterface $em)
    {
        $this->commandeRepository= $commandeRepository;
        $this->em = $em;
    }

    #[Route('/', name: 'app_liste_commande')]
    public function index(): Response
    {
        $orders=$this->commandeRepository->findall();
        return $this->render('liste_commande/index.html.twig', [
            'orders' => $orders,
        ]);
    }


    #[Route('/confirmation/{id}', name: 'commande.confirmation')]
    public function confirmation(Commande $commande, \Symfony\Component\HttpFoundation\Request $request) {
        $form = $this->createForm(ConfirmOrderFormType::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirect('../');
        }

        return $this->render('liste_commande/confirmer.html.twig', [
            "commande" => $commande,
            "form" => $form->createView()
        ]);
    }

}
