<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\WeightCalculationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        WeightCalculationServiceInterface $weightCalculationService,
        Security                          $security
    ): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_homepage');
        }

        $user = $security->getUser();
        assert($user instanceof User);

        if (!is_null($user->getHeight()) && !is_null($user->getAge())) {
            $idealWeight = $weightCalculationService->calculateIdealWeight($user->getHeight(), $user->getAge(), $user->getBodyType()) . 'kg';
        } else {
            $idealWeight = 'Please add data in user settings';
        }

        return $this->render('dashboard/index.html.twig', [
            'idealWeight' => $idealWeight
        ]);
    }
}
