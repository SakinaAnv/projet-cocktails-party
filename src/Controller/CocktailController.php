<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Form\CocktailType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CocktailController extends AbstractController
{


    #[Route('/cocktail', name: 'cocktail_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Cocktail::class);
        $cocktails = $repository->findAll();
        return $this->render('cocktail/index.html.twig',
            ['cocktails' => $cocktails]);
    }


    #[Route('/cocktail/add', name: 'cocktail_add')]
    public function create(Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $cocktail = new Cocktail();

        $form = $this->createForm(CocktailType::class, $cocktail);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->remove('deletedAt');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('cocktail_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $cocktail->setImagePath($newFilename);
            }
            $manager = $doctrine->getManager();
            $manager->persist($cocktail);
            $manager->flush();

            $this->addFlash('success', $cocktail->getName() . " a été ajouté avec succès");
            return $this->redirectToRoute('cocktail_list');
        } else {
            return $this->renderForm('cocktail/addCocktail.html.twig', [
                'form' => $form,
            ]);
        }


    }



}
