<?php

namespace App\Controller;

use App\Entity\Destinations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class DestinationsController extends AbstractController
{
    #[Route('/destinations', name: 'app_destinations1')]
    public function destinations(): Response
    {
        return $this->render('destinations/index.html.twig', [
            'controller_name' => 'DestinationsController',
        ]);
    }

    #[Route('/index', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $destinations = $doctrine
            ->getRepository(Destinations::class)
            ->findAll();
        if (!$destinations) {
            throw $this->createNotFoundException(
                'No destinations found '
            );
        }else {}
        return $this->render('destinations/index.html.twig', [
           
           
            'destinations' => $destinations,
            
        ]);
    }


    #[Route('/create', name: 'create_action')]
    public function createAction(ManagerRegistry $doctrine)
    {   
        
        // you can fetch the ManagerRegistry via $doctrine()
        $em = $doctrine->getManager();
        $product = new Destinations(); // here we will create an object from our class Product.
        $product->setName('Phuket'); // in our Product class we have a set function for each column in our db
        $product->setContinent('Asia');
        $product->setCountry('Thailand');
 
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        return new Response('Saved new product with id'.$product->getId());
    }

    #[Route('/details/{id}', name: 'details_action')]  
    public function showDetailsAction($id, ManagerRegistry $doctrine)
    {
        $product = $doctrine
            ->getRepository(Destinations::class)
            ->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }else {
            #return new Response (gettype($product));
            $details=['id'=>$product->getId(),
            'name'=>$product->getName(),
            'country'=>$product->getCountry(),
            'continent'=>$product->getContinent(),
            'image'=>$product->getImage(),
            'description'=>$product->getDescription()];
            $tbody = "<tr>
            <td>" .$details['name']."</td>
            <td>" .$details['country']."</td>
            <td>" .$details['continent']."</td>
            <td><img class='img-thumbnail' src=".('images/' .$details['image'])."'</td>
            <td>" .$details['description']."</td>
            
          
          
           <td><a href='update.php?id=" .$details['id']."'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
           <a href='delete.php?id=" .$details['id']."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
            </tr>";
            
           
            
            $response ='Details from the product with id '.$id.", Product name is ".$product->getName()." and it is in ".$product->getCountry()." in ".$product->getContinent();
            return $this->render('destinations/details.html.twig', [
                'response' => $response,
                'product' => $product,
                'details'=>$details,
                'tbody'=>$tbody
            ]);
            
        }
    }
}
