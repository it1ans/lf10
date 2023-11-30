<?php

namespace App\Controller;

use App\Entity\EatenMeal;
use App\Form\EatenMealType;
use App\Repository\EatenMealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EatenMealController extends AbstractController
{
    #[Route('/eatenMeal/add', name: 'app_eatenMeal_add', methods: ['GET', 'POST'])]
    public function addMealToUser(Request $request, EntityManagerInterface $entityManager)
    {
        $eatenMeal = new EatenMeal();
        $eatenMeal->setUser($this->getUser());
        $form = $this->createForm(EatenMealType::class, $eatenMeal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eatenMeal->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($eatenMeal);
            $entityManager->flush();

            $this->addFlash('success', 'Meal ' . $eatenMeal->getMeal()->getName() . ' has been added successfully');
            return $this->redirectToRoute('app_eatenMeal_list');
        }

        return $this->renderForm('eaten_meal/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/eatenMeal', name: 'app_eatenMeal_list', methods: ['GET'])]
    public function index(EatenMealRepository $eatenMealRepository)
    {
        $meals = $eatenMealRepository->findByUser($this->getUser());

        return $this->render('eaten_meal/index.html.twig', [
            'meals' => $meals,
        ]);
    }

    #[Route('/eatenMeal/delete/{id}', name: 'app_eatenMeal_delete', methods: ['GET'])]
    public function delete(EatenMeal $eatenMeal, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($eatenMeal);
        $entityManager->flush();

        $this->addFlash('success', 'Eaten Meal ' . $eatenMeal->getMeal()->getName() . ' has been deleted.');
        return $this->redirectToRoute('app_eatenMeal_list');
    }
}
