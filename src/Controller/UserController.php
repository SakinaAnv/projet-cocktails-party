<?php

namespace App\Controller;

use App\Entity\User;
use App\Events\AddUserEvent;
use App\Form\UserType;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user'),
IsGranted('ROLE_USER')
]
class UserController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
       private EventDispatcherInterface $dispatcher
    )
    {
    }

    #[Route('/', name: 'client_list')]
    public function ListClient(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $personnes = $repository->findByRole('["ROLE_CLIENT"]');
        return $this->render('user/index.html.twig',
            ['personnes' => $personnes]);
    }

    #[Route('/Staff', name: 'personnel_list')]
    public function ListStaff(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $personnes = $repository->findByRole('["ROLE_STAFF"]');
        return $this->render('user/index.html.twig',
            ['personnes' => $personnes]);
    }




    #[Route('/edit/{id?0}', name: 'user_edit')]
    public function editUser(
        User $personne = null,
        EntityManagerInterface $entityManager,
        Request $request,
        MailerService $mailer
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $new = false;
        if (!$personne) {
            $new = true;
            $personne = new User();
        }

        $form = $this->createForm(UserType::class, $personne);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->remove('deletedAt');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ROLES = $form->get('roles')->getData();
            $mdp = $form->get('password')->getData();
            if ($ROLES ) {
                $personne->setRoles([$ROLES]);
            }
            if ($mdp) {
                $personne->setPassword($this->hasher->hashPassword($personne, $mdp));
            }

            $entityManager->persist($personne);
            $entityManager->flush();
            if($new) {
               $message = " a été ajouté avec succès";
               $addUserEvent = new AddUserEvent($personne);
              $this->dispatcher->dispatch($addUserEvent, AddUserEvent::ADD_USER_EVENT);
            } else {
            $message = " a été mis à jour avec succès";
        }
            $this->addFlash('success', $personne->getName() ." ". $personne->getFirstname() .  $message);
            return $this->redirectToRoute('client_list');
        } else {

            return $this->render('user/addUser.html.twig', [
                'form' => $form->createView()
            ]);
        }

    }

    #[
        Route('/delete/{id}', name: 'user_delete'),
        IsGranted('ROLE_ADMIN')
    ]
    public function deleteUser(User $personne = null, ManagerRegistry $doctrine): RedirectResponse {
        if ($personne) {
            $manager = $doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', "L'utilisateur a été supprimé avec succès");
        } else {
            $this->addFlash('error', "L'utilisateur n'existe pas");
        }
        return $this->redirectToRoute('client_list');
    }


    #[Route('/alls/{page?1}/{nbre?10}', name: 'user.list.all')]
    public function indexAlls(ManagerRegistry $doctrine,$page,$nbre):Response{
        $repository=$doctrine->getRepository('App:User');
        $nbPersonne = $repository->count([]);
        $nbrePage = ceil($nbPersonne / $nbre) ;
        $personnes=$repository->findBy([], [],$nbre,($page-1)*$nbre);
        return $this->render('user/index.html.twig', [
            'personnes' => $personnes,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
}
