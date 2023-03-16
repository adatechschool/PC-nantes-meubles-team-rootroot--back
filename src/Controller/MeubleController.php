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

        $meuble->setType($request->request->get('type'));
        $meuble->setPrix($request->request->get('prix'));
        $meuble->setCouleur($request->request->get('couleur'));
        $meuble->setDescription($request->request->get('description'));

        $entityManager->persist($meuble);
        $entityManager->flush();

        return $this->json('Created new meuble successfully with id ' . $meuble->getId());
    }

    /*#[Route('/put_meuble/{id}', name: 'put_meuble', methods: 'PUT')]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $meuble = $entityManager->getRepository(Meubles::class)->find($id);

        if (!$meuble) {
            return $this->json('No project found for id' . $id, 404);
        }

        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        if($request->request->get('type')){
            $meuble->setType($request->request->get('type'));
        }
        if($request->request->get('prix')){
            $meuble->setPrix($request->request->get('prix'));
        }
        if($request->request->get('couleur')){
            $meuble->setCouleur($request->request->get('couleur'));
        }
        if($request->request->get('description')){
            $meuble->setDescription($request->request->get('description'));
        }
        $entityManager->flush();

        $data = [
            'id' => $meuble->getId(),
            'type' => $meuble->getType(),
            'prix' => $meuble->getPrix(),
            'couleur' => $meuble->getCouleur(),
            'description' => $meuble->getDescription(),
        ];

        return $this->json($data);
    }*/

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

        return $this->json('Deleted a project successfully with id ' . $id);
    }

    //TEST QUERY
    #[Route('/put_meuble/{id}/{type}/{prix}/{couleur}/{description}', name: 'put_meuble', methods: 'PUT')]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id,$type,$prix,$couleur,$description): Response
    {
        //$entityManager = $doctrine->getManager();
        //$meuble = $entityManager->getRepository(Meubles::class)->find($id);
        $type=dump($type);
        $prix=dump($prix);
        $couleur=dump($couleur);
        $description= dump($description);
        //$data = json_decode($request->getContent(), true);
        //$request->request->replace($data);

        $entityManager = $doctrine->getManager();
        $meuble = $entityManager->getRepository(Meubles::class)->find($id);

        if($type){
            $meuble->setType($type);
        }
        if($prix){
            $meuble->setPrix($prix);
        }
        if($couleur){
            $meuble->setCouleur($couleur);
        }
        if($description){
            $meuble->setDescription($description);
        }


        $entityManager->flush();

        $data = [
            'id' => $meuble->getId(),
            'type' => $meuble->getType(),
            'prix' => $meuble->getPrix(),
            'couleur' => $meuble->getCouleur(),
            'description' => $meuble->getDescription(),
        ];

        return $this->json($data);
    }
}