<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\EatenMealRepository;
use App\Service\WeightCalculationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        EatenMealRepository               $eatenMealRepository,
        Security                          $security,
        WeightCalculationServiceInterface $weightCalculationService,
    ): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_homepage');
        }

        $user = $this->getUser();
        assert($user instanceof User);

        if (!is_null($user->getHeight()) && !is_null($user->getAge())) {
            $idealWeight = $weightCalculationService->calculateIdealWeight($user->getHeight(), $user->getAge(), $user->getBodyType()) . 'kg';
        } else {
            $idealWeight = 'Please add data in user settings';
        }

        $dailyMeals = $eatenMealRepository->findTodayMeals($user);
        $usedCalories = $eatenMealRepository->findTodayCalories($user);

        if (!is_null($user->getWeight()) && !is_null($user->getGender())) {
            $dailyCalories = $weightCalculationService->calculateDailyCalories($user->getWeight(), $user->getGender());
        } else {
            $this->addFlash('danger', 'Please add at least weight and gender data');
            return $this->redirectToRoute('app_user_edit');
        }

        return $this->render('dashboard/index.html.twig', [
            'idealWeight' => $idealWeight,
            'dailyMeals' => $dailyMeals,
            'dailyCalories' => $dailyCalories,
            'usedCalories' => $usedCalories,
        ]);
    }
}
