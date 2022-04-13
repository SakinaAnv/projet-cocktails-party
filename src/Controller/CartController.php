<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, CocktailRepository $cocktailRepository): \Symfony\Component\HttpFoundation\Response
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données
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
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $cocktail->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Cocktail $cocktail, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $cocktail->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Cocktail $cocktail, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $cocktail->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }

}