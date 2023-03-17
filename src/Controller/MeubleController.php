<?php
// Defines that the following code is located within the App\Controller namespace.
namespace App\Controller;

//Imports the AbstractController class from the Symfony\Bundle\FrameworkBundle\Controller namespace, which is a base controller class that provides useful methods for working with Symfony applications.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//Imports the Response class from the Symfony\Component\HttpFoundation namespace, which is used to create HTTP responses to be sent back to the client.
use Symfony\Component\HttpFoundation\Response;
//Imports the Route class from the Symfony\Component\Routing\Annotation namespace, which is used to define routes for Symfony controllers.
use Symfony\Component\Routing\Annotation\Route;
// Importing the ManagerRegistry and Request classes
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Importing the Meubles entity class
use App\Entity\Meubles;
// Importing the LoggerInterface class
use Psr\Log\LoggerInterface;


class MeubleController extends AbstractController
{
    // Route that returns all data from the Meubles entity as JSON
    #[Route('/get_all_data_meuble', name: 'get_meuble', methods: 'GET')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $meubles = $doctrine
            ->getRepository(Meubles::class)
            ->findAll();

        // Initialize an empty array to store data for each Meubles entity
        $data = [];

        // Loop through each Meubles entity and add its data to the $data array
        foreach ($meubles as $meuble) {
            $data[] = [
                'id' => $meuble ->getId(),
                'title' => $meuble ->getTitle(),
                'category' => $meuble ->getCategory(),
                'price' => $meuble ->getPrice(),
                'dimension' => $meuble ->getDimension(),
                'color'=> $meuble ->getColor(),
                'material'=> $meuble ->getMaterial(),
                'status'=> $meuble ->isStatus(),
                'picture'=> $meuble ->getPicture(),
                'description' => $meuble ->getDescription(),
            ];
        }
        // Return the $data array as a JSON response
        return $this->json($data);
    }

    // Route that returns data from the Meubles entity as JSON, but only specific fields
    #[Route('/get_all_card_meuble', name: 'get_card', methods: 'GET')]
    public function getCard(ManagerRegistry $doctrine): Response
    {
        // Get all Meubles entities from the database
        $meubles = $doctrine
            ->getRepository(Meubles::class)
            ->findAll();

        // Initialize an empty array to store data for each Meubles entity
        $data = [];

        // Loop through each Meubles entity and add its data to the $data array, but only specific fields
        foreach ($meubles as $meuble) {
            $data[] = [
                'id' => $meuble ->getId(),
                'title' => $meuble ->getTitle(),
                'picture'=> $meuble ->getPicture(),
                'category'=> $meuble ->getCategory(),
                'price'=> $meuble ->getPrice()
            ];
        }
        // Return the $data array as a JSON response
        return $this->json($data);
    }


    // Route that creates a new Meubles entity in the database
    #[Route('/post_meuble', name: 'post_meuble', methods: 'POST')]
    public function new (ManagerRegistry $doctrine, Request $request, LoggerInterface $logger)
    {
        // Get the Doctrine entity manager
        $entityManager = $doctrine->getManager();

        $meuble = new Meubles();

        // Get the request data as an array
        $data = json_decode($request->getContent(), true);
        // Replace the request data with the array data
        $request->request->replace($data);

        // Set the properties of the new Meubles entity using the request data

        $meuble->setTitle($request->request->get('title'));
        $meuble->setCategory($request->request->get('category'));
        $meuble->setPrice($request->request->get('price'));
        $meuble->setDimension($request->request->get('dimension'));
        $meuble->setColor($request->request->get('color'));
        $meuble->setMaterial($request->request->get('material'));
        $meuble->setStatus($request->request->get('status'));
        $meuble->setPicture($request->request->get('picture'));
        $meuble->setDescription($request->request->get('description'));

        //tells the Doctrine ORM to track and save the $meuble object to the database when the flush() method is called.
        $entityManager->persist($meuble);
        //saves any changes made to managed entities to the database.
        $entityManager->flush();

        return $this->json('Created new meuble successfully with id ' . $meuble->getId());
    }
    //Route that modify a meuble with one or mor param with the URL
    // the requirement is a REGEX , .+ matches one or more characters.
    #[Route('/put_meuble/{id}/{params}', name:'put_meuble', methods:'PUT', requirements:['params'=>'.+'])]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id, $params): Response
    {
        // Get the Doctrine entity manager
        $entityManager = $doctrine->getManager();
    
        // Find the Meubles entity with the given ID
        $meuble = $entityManager->getRepository(Meubles::class)->find($id);
    
        // Parse the parameters in the {params} wildcard
        //a wildcard is a character or a sequence of characters that can be used to represent any other character or characters in a string.
        $parsedParams = [];
        foreach (explode('/', $params) as $param) {
            // Split each parameter into key/value pairs
            list($key, $value) = explode('=', $param);
    
            // Store the key/value pairs in an array
            $parsedParams[$key] = $value;
        }
    
        // Update the Meubles entity with the parsed parameters, if they exist

        if (isset($parsedParams['title'])) {
            $meuble->setTitle($parsedParams['title']);
        }
        if (isset($parsedParams['category'])) {
            $meuble->setCategory($parsedParams['category']);
        }
        if (isset($parsedParams['price'])) {
            $meuble->setPrice($parsedParams['price']);
        }
        if (isset($parsedParams['dimension'])) {
            $meuble->setDimension($parsedParams['dimension']);
        }
        if (isset($parsedParams['color'])) {
            $meuble->setColor($parsedParams['color']);
        }
        if (isset($parsedParams['material'])) {
            $meuble->setMaterial($parsedParams['material']);
        }
        if (isset($parsedParams['status'])) {
            $meuble->setStatus($parsedParams['status']);
        }
        if (isset($parsedParams['picture'])) {
            $meuble->setPicture($parsedParams['picture']);
        }
        if (isset($parsedParams['description'])) {
            $meuble->setDescription($parsedParams['description']);
        }
    
        // Save the updated entity to the database
        $entityManager->flush();
    
        // Return a JSON response with the updated Meubles
        return $this->json('Succes updating');
    }

    #[Route('/delete_meuble/{id}', name: 'delete_meuble', methods: 'DELETE')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $meuble = $entityManager->getRepository(Meubles::class)->find($id);

        if (!$meuble) {
            return $this->json('No project found for id' . $id, 404);
        }
        
        //removes a specific entity object from the database using the EntityManager.
        $entityManager->remove($meuble);
        // Save the updated entity to the database
        $entityManager->flush();

        return $this->json('Deleted a furniture successfully with id ' . $id);
    }

}