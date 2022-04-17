<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Entity\Order;
use App\Repository\CocktailRepository;
use App\Repository\TableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, CocktailRepository $cocktailRepository): \Symfony\Component\HttpFoundation\Response
    {
        $panier = $session->get("panier", []);
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $cocktail = $cocktailRepository->find($id);
            $dataPanier[] = [
                "produit" => $cocktail,
                "quantite" => $quantite
            ];
            $total += $cocktail->getPrice() * $quantite;
        }

        return $this->render('Cart/index.html.twig', compact("dataPanier", "total"));

    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Cocktail $cocktail, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $panier = $session->get("panier", []);
        $id = $cocktail->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Cocktail $cocktail, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {

        $panier = $session->get("panier", []);
        $id = $cocktail->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Cocktail $cocktail, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {

        $panier = $session->get("panier", []);
        $id = $cocktail->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(
        SessionInterface $session,
        CocktailRepository $cocktailRepository,
        ?UserInterface $user,
        EntityManagerInterface $entityManager,
        TableRepository $tableRepo
    ): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $commande = new Order();
        $table= $tableRepo->find($session->get("table"));
        $commande->setIdTable($table);
        $table->setAccessibility('false');
        if ($user) {
            $commande->setIdUser($user);
        }

        $panier = $session->get("panier", []);
        $cocktails=[];

        foreach($panier as $id => $quantite){
            $cocktail = $cocktailRepository->find($id);
            $commande->addCocktail($cocktail);
        }
        $entityManager->persist($commande);
        $entityManager->flush();
        $entityManager->persist($table);
        $entityManager->flush();

        $session->remove("panier");

        $this->addFlash('success', 'Votre commande a été pris en compte. Merci de patienter un moment');
        return $this->redirectToRoute("listeCocktails");
    }

}