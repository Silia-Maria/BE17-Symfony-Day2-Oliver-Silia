<?php

namespace App\Controller;

use App\Entity\Destinations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

class TravelAgencyController extends AbstractController
{
    #Routes for different pages
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

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('travel_agency/contact.html.twig', []);
    }

    # function to print in news
    # findAll gives you an array so in html.twig you need to use destination[0].image!!
    #[Route('/news', name: 'news')]
    public function news(ManagerRegistry $doctrine): Response
    {
        $destinations = $doctrine->getRepository(Destinations::class)->findAll();
        # Destinations comes from Entity folder Destinations.php

        return $this->render('travel_agency/news.html.twig', ['destination' => $destinations]);
    }

    #function to create new record
    #[Route('/create', name: 'create')]
    public function destinatios(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $destinations = new Destinations();
        $destinations->setName('Costa Rica');
        $destinations->setPrice(299, 99);
        $destinations->setImage('https://images.unsplash.com/photo-1503457574462-bd27054394c1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80');
        $em->persist($destinations);
        $em->flush();
        return new Response("Destinations is created");
    }
}
