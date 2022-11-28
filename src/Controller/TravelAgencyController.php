<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravelAgencyController extends AbstractController
{
    #[Route('/travel-agency', name: 'app_travel_agency')]
    public function index(): Response
    {
        return $this->render('travel_agency/index.html.twig', [
            'controller_name' => 'TravelAgencyController',
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('travel_agency/about.html.twig', []);
    }
}
