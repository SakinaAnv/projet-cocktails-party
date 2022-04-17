<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'list_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/order/detail/{id<\d+>}', name: 'order_detail')]
    public function detailOrder(Order $order = null,$id): Response
    {
        if(!$order) {
            $this->addFlash('error', "La commande n'existe pas ");
            return $this->redirectToRoute('list_order');
        }

        return $this->render('order/detailOrder.html.twig', [
            'order' => $order->getCocktails(),
            'id'=> $id
            ]);
    }


    #[Route('/order/terminer/{id<\d+>}', name: 'order_terminate'),
        IsGranted('ROLE_ADMIN')
    ]
    public function TerminateOder(Order $order = null, EntityManagerInterface $entityManager): RedirectResponse {
        if ($order) {
            $order->setEtat('Terminé');
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success', "La commande est terminée");
        } else {
            $this->addFlash('error', "La commande n'existe pas");
        }
        return $this->redirectToRoute('list_order');
    }
}
