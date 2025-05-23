<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Entity\File;

final class UserController extends AbstractController
{
    #[Route('/profil/my', name: 'app_user')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/{id}', name: 'user_profil')]
    public function profil($id, UserRepository $userRepository, PostRepository $postRepository): Response
    {
        $profil = $userRepository->find($id);
        $user_created_id = $userRepository->find($id);
        $user_connected = $this->getUser();
        $post = $postRepository->mesPosts($user_created_id);

        if ($id == "5") {
            $this->redirectToRoute('app_user');
        }

        return $this->render('user/profil.html.twig', [
            'user'=> $profil,
            'post'=> $post,
        ]);
    }

    #[Route('/profil/my/edit/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(\Symfony\Component\HttpFoundation\Request $request, User $user, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                // L'appel à setImageFile gère l'upload et la mise à jour de la date
                $user->setImageFile($imageFile);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}