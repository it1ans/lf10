<?php

namespace App\Controller;

use App\Form\EditUserDataFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/edit', name: 'app_user_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $form = $this->createForm(EditUserDataFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->renderForm('user/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/user/view', name: 'app_user_view')]
    public function view(): Response
    {
        $user = $this->getUser();

        return $this->render('user/view.html.twig', [
            'user' => $user
        ]);
    }
}