<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Events\AddCocktailEvent;
use App\Form\CocktailType;
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


#[Route('/cocktail'),
    IsGranted('ROLE_USER')
]
class CocktailController extends AbstractController
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    #[Route('/', name: 'cocktail_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Cocktail::class);
        $cocktails = $repository->findAll();
        return $this->render('cocktail/index.html.twig',
            ['cocktails' => $cocktails]);
    }


    #[Route('/edit/{id?0}', name: 'cocktail_edit')]
    public function editUser(
        Cocktail $cocktail = null,
        EntityManagerInterface $entityManager,
        UploaderService $uploaderService,
        Request $request
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $new = false;
        if (!$cocktail) {
            $new = true;
            $cocktail = new Cocktail();
        }

        $form = $this->createForm(CocktailType::class, $cocktail);
        $form->remove('createdAt');
        $form->remove('updatedAt');


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('photo')->getData();

            if ($photo) {
                $directory = $this->getParameter('cocktail_directory');
                $cocktail->setImagePath($uploaderService->uploadFile($photo, $directory));
            }
            $entityManager->persist($cocktail);
            $entityManager->flush();
            if($new) {
                $message = " a été ajouté avec succès";
                $addCocktailEvent = new AddCocktailEvent($cocktail);
                $this->dispatcher->dispatch($addCocktailEvent, AddCocktailEvent::ADD_COCKTAIL_EVENT);
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success', $cocktail->getName() ." " .  $message);
            return $this->redirectToRoute('cocktail_list');
        } else {

            return $this->render('cocktail/addCocktail.html.twig', [
                'form' => $form->createView()
            ]);
        }

    }

    #[
        Route('/delete/{id}', name: 'cocktail_delete'),
        IsGranted('ROLE_ADMIN')
    ]
    public function deleteUser(Cocktail $cocktail = null, ManagerRegistry $doctrine): RedirectResponse {
        if ($cocktail) {
            $manager = $doctrine->getManager();
            $manager->remove($cocktail);
            $manager->flush();
            $this->addFlash('success', "Le cocktail a été supprimé avec succès");
        } else {
            $this->addFlash('error', "Le cocktail n'existe pas");
        }
        return $this->redirectToRoute('cocktail_list');
    }
}
