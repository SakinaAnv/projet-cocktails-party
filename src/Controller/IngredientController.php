<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Services\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'ingredient')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Ingredient::class);
        $ingredient = $repository->findAll();

        return $this->render('ingredient/index.html.twig',
            ['ingredients' => $ingredient]
        );
    }

    #[Route('ingredient/pdf', name: 'ingredient_pdf')]
    public function generatePdfIngredientFini(Ingredient $ingredient=null , PdfService $pdf,ManagerRegistry $doctrine) {
        $repository = $doctrine->getRepository(Ingredient::class);
        $ingredients = $repository->findByQuantiteInferieur(10);
        $html = $this->render('ingredient/index.html.twig',
            ['ingredients' => $ingredients,
                'ingredient' => $ingredient

                ]);
        $pdf->showPdfFile($html);
    }

    #[Route('/ingredient/add', name: 'ingredient_add')]
    public function addIngredient(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form-> remove('createdAt');
        $form-> remove('updatedAt');
        $form-> remove('deletedAt');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $photo = $form->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('ingredient_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $ingredient->setImagePath($newFilename);
            }
            $manager = $doctrine->getManager();
            $manager->persist($ingredient);
            $manager->flush();


            $this->addFlash('success', $ingredient->getName()  . " a été ajouté avec succès");
            return $this->redirectToRoute('ingredient');
        } else {
            return $this->renderForm('ingredient/addIngredient.html.twig', [
                'form' => $form,
            ]);
        }

    }

}
