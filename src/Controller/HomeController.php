<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\WeightCalculationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        WeightCalculationServiceInterface $weightCalculationService,
        Security                          $security
    ): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        $user = $security->getUser();
        assert($user instanceof User);

        $idealWeight = $weightCalculationService->calculateIdealWeight($user->getHeight(), $user->getAge(), $user->getBodyType());

        return $this->render('home/index.html.twig', [
            'idealWeight' => $idealWeight
        ]);
    }
}
