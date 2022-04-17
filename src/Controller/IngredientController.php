<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Events\AddIngredientEvent;
use App\Form\IngredientType;
use App\Services\PdfService;
use App\Services\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/ingredient'),
    IsGranted('ROLE_USER')
]
class IngredientController extends AbstractController
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }
/*
    #[Route('/{pdfChecker}', name: 'ingredient')]
    public function index(ManagerRegistry $doctrine,PdfService $pdf,$pdfChecker): Response
    {
        $repository = $doctrine->getRepository(Ingredient::class);
        $ingredient = $repository->findAll();
        if ($pdfChecker == true){
            $ingredients = $repository->findByQuantiteInferieur(10);
            $html = $this->render('ingredient/stockFini.html.twig',
                ['ingredients' => $ingredients]
            );
             $pdf->showPdfFile($html);
        }

        return $this->render('ingredient/index.html.twig',
            ['ingredients' => $ingredient]
        );

    }
*/

    #[Route('/', name: 'ingredient')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Ingredient::class);
        $ingredient = $repository->findAll();

        return $this->render('ingredient/index.html.twig',
            ['ingredients' => $ingredient]
        );
    }
/*
    #[Route('/pdf', name: 'ingredient_pdf')]
    public function generatePdfIngredientFini(Ingredient $ingredient=null, PdfService $pdf,ManagerRegistry $doctrine) {
        $repository = $doctrine->getRepository(Ingredient::class);
        $ingredients = $repository->findByQuantiteInferieur(10);
        $html = $this->render('ingredient/stockFini.html.twig',
            ['ingredients' => $ingredients,
                'ingredient' => $ingredient
                ]);

        $pdf->showPdfFile($html);
    }


*/

    #[Route('/pdf', name: 'ingredient_pdf'),
   IsGranted('ROLE_ADMIN')

   ]
    public function generatePdfIngredientFini( PdfService $pdf,ManagerRegistry $doctrine) {
        $repository = $doctrine->getRepository(Ingredient::class);
        $ingredients = $repository->findByQuantiteInferieur(10);
        $html = $this->render('ingredient/index.html.twig',
            ['ingredients' => $ingredients]
        );

        $pdf->showPdfFile($html);
    }

    #[Route('/edit/{id?0}', name: 'ingredient_edit')]
    public function editUser(
        Ingredient $ingredient = null,
        EntityManagerInterface $entityManager,
        UploaderService $uploaderService,
        Request $request
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $new = false;
        if (!$ingredient) {
            $new = true;
            $ingredient = new Ingredient();
        }

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->remove('deletedAt');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('photo')->getData();
            if ($photo) {
                $directory = $this->getParameter('ingredient_directory');
                $ingredient->setImagePath($uploaderService->uploadFile($photo, $directory));
            }
            $entityManager->persist($ingredient);
            $entityManager->flush();
            if($new) {
                $message = " a été ajouté avec succès";
                $addIngredientEvent = new AddIngredientEvent($ingredient);
                $this->dispatcher->dispatch($addIngredientEvent, AddIngredientEvent::ADD_Ingredient_EVENT);
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success', $ingredient->getName() ." " .  $message);
            return $this->redirectToRoute('ingredient');
        } else {

            return $this->render('ingredient/addIngredient.html.twig', [
                'form' => $form->createView()
            ]);
        }

    }

    #[
        Route('/delete/{id}', name: 'ingredient_delete'),
        IsGranted('ROLE_ADMIN')
    ]
    public function deleteUser(Ingredient $ingredient = null, ManagerRegistry $doctrine): RedirectResponse {
        if ($ingredient) {
            $manager = $doctrine->getManager();
            $manager->remove($ingredient);
            $manager->flush();
            $this->addFlash('success', "L'ingrédient a été supprimé avec succès");
        } else {
            $this->addFlash('error', "L'ingrédient n'existe pas");
        }
        return $this->redirectToRoute('ingredient');
    }
}
