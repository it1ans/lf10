<?php

namespace App\Controller;

use App\Entity\EatenMeal;
use App\Entity\Meal;
use App\Entity\User;
use App\Form\EatenMealType;
use App\Form\MealType;
use App\Repository\MealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/meal')]
class MealController extends AbstractController
{
    #[Route('/', name: 'app_meal_index', methods: ['GET'])]
    public function index(Request $request, MealRepository $mealRepository): Response
    {
        $ownMealsOnly = $request->query->get('ownMeals');

        if ($ownMealsOnly === 'true') {
            $meals = $mealRepository->findOwnMeals($this->getUser());
        } else {
            $meals = $mealRepository->findPublicOrOwn($this->getUser());
            $ownMealsOnly = 'false';
        }

        return $this->render('meal/index.html.twig', [
            'meals' => $meals,
            'ownMealsOnly' => $ownMealsOnly,
        ]);
    }

    #[Route('/new', name: 'app_meal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        /** @var FormInterface $form */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('meal_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $meal->setImageFilename($newFilename);
            }

            $meal->setUser($this->getUser());

            $entityManager->persist($meal);
            $entityManager->flush();

            return $this->redirectToRoute('app_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meal_show', methods: ['GET'])]
    public function show(Meal $meal): Response
    {
        return $this->render('meal/show.html.twig', [
            'meal' => $meal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meal $meal, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        assert($user instanceof User);
        if ($meal->getUser()->getId() !== $user->getId()) {
            $this->addFlash('danger', 'You cannot edit a meal from another user.');
            return $this->redirectToRoute('app_meal_index');
        }

        $form = $this->createForm(MealType::class, $meal);
        /** @var FormInterface $form */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();


                try {
                    $imageFile->move(
                        $this->getParameter('meal_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $meal->setImageFilename($newFilename);
            }

            $entityManager->persist($meal);
            $entityManager->flush();

            $this->addFlash('success', 'Meal ' . $meal->getName() . ' has been updated.');
            return $this->redirectToRoute('app_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_meal_delete')]
    public function delete(Request $request, Meal $meal, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        assert($user instanceof User);
        if ($meal->getUser()->getId() !== $user->getId()) {
            $this->addFlash('danger', 'You cannot delete a meal from another user.');
            return $this->redirectToRoute('app_meal_index');
        }

        $entityManager->remove($meal);
        $entityManager->flush();

        return $this->redirectToRoute('app_meal_index', [], Response::HTTP_SEE_OTHER);
    }
}
