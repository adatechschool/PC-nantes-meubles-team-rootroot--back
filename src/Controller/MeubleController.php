<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Importing the ManagerRegistry and Request classes
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Meubles;

use Psr\Log\LoggerInterface;


class MeubleController extends AbstractController
{
    #[Route('/get_all_data_meuble', name: 'get_meuble', methods: 'GET')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $meubles = $doctrine
            ->getRepository(Meubles::class)
            ->findAll();

        $data = [];

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
        return $this->json($data);
    }

    #[Route('/get_all_card_meuble', name: 'get_card', methods: 'GET')]
    public function getCard(ManagerRegistry $doctrine): Response
    {
        $meubles = $doctrine
            ->getRepository(Meubles::class)
            ->findAll();

        $data = [];

        foreach ($meubles as $meuble) {
            $data[] = [
                'id' => $meuble ->getId(),
                'title' => $meuble ->getTitle(),
                'picture'=> $meuble ->getPicture(),
                'category'=> $meuble ->getCategory(),
                'price'=> $meuble ->getPrice()
            ];
        }
        return $this->json($data);
    }



    #[Route('/post_meuble', name: 'post_meuble', methods: 'POST')]
    public function new (ManagerRegistry $doctrine, Request $request, LoggerInterface $logger)
    {
        $entityManager = $doctrine->getManager();

        $meuble = new Meubles();

        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $meuble->setTitle($request->request->get('title'));
        $meuble->setCategory($request->request->get('category'));
        $meuble->setPrice($request->request->get('price'));
        $meuble->setDimension($request->request->get('dimension'));
        $meuble->setColor($request->request->get('color'));
        $meuble->setMaterial($request->request->get('material'));
        $meuble->setStatus($request->request->get('status'));
        $meuble->setPicture($request->request->get('picture'));
        $meuble->setDescription($request->request->get('description'));


        $entityManager->persist($meuble);
        $entityManager->flush();

        return $this->json('Created new meuble successfully with id ' . $meuble->getId());
    }

    #[Route('/put_meuble/{id}/{params}', name:'put_meuble', methods:'PUT', requirements:['params'=>'.+'])]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id, $params): Response
    {
        // Get the Doctrine entity manager
        $entityManager = $doctrine->getManager();
    
        // Find the Meubles entity with the given ID
        $meuble = $entityManager->getRepository(Meubles::class)->find($id);
    
        // Parse the parameters in the {params} wildcard
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

        $entityManager->remove($meuble);
        $entityManager->flush();

        return $this->json('Deleted a furniture successfully with id ' . $id);
    }

}