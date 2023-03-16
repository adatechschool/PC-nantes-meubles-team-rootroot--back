<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Meubles;

use Psr\Log\LoggerInterface;


class MeubleController extends AbstractController
{
    #[Route('/get_meubles', name: 'get_meubles', methods: 'GET')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine
            ->getRepository(Meubles::class)
            ->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'type' => $product->getType(),
                'prix' => $product->getPrix(),
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

        $meuble->setPrice($request->request->get('price'));
        $meuble->setDescription($request->request->get('description'));
        $meuble->setTitle($request->request->get('title'));
        $meuble->setDimension($request->request->get('dimension'));
        $meuble->setColor($request->request->get('color'));
        $meuble->setMaterial($request->request->get('material'));
        $meuble->setPicture($request->request->get('picture'));


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
        $updatesParameters='';

        if (isset($parsedParams['description'])) {
            $meuble->setDescription($parsedParams['description']);
            $updatesParameters+=' description';
        }
        if (isset($parsedParams['price'])) {
            $meuble->setPrice($parsedParams['price']);
            $updatesParameters+=' price';
        }
        if (isset($parsedParams['title'])) {
            $meuble->setTitle($parsedParams['title']);
            $updatesParameters+=' title';
        }
        if (isset($parsedParams['picture'])) {
            $meuble->setPicture($parsedParams['picture']);
            $updatesParameters+=' pictures';
        }
        if (isset($parsedParams['categorie'])) {
            $meuble->setCategories($parsedParams['categorie']);
            $updatesParameters+=' categorie';
        }
        if (isset($parsedParams['dimension'])) {
            $meuble->setDimension($parsedParams['dimension']);
            $updatesParameters+=' dimension';
        }
        if (isset($parsedParams['color'])) {
            $meuble->setColor($parsedParams['color']);
            $updatesParameters+=' color';
        }
        if (isset($parsedParams['material'])) {
            $meuble->setMaterial($parsedParams['material']);
            $updatesParameters+=' material';
        }
    
        // Save the updated entity to the database
        $entityManager->flush();
    
        // Return a JSON response with the updated Meubles entity's data
        $data = [
            'id' => $meuble->getId(),
            'type' => $meuble->getType(),
            'prix' => $meuble->getPrix(),
            'couleur' => $meuble->getCouleur(),
            'description' => $meuble->getDescription(),
        ];
        return $this->json('Succes updating' .$updatesParameters);
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