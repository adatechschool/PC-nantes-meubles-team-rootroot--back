<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class LoginController extends AbstractController
{
    
    #[Route('/login', name:'login', methods:'GET')]
    
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        var_dump($request->request);
        //die('test');
        
        $email = $request->request->get('email');
        $password = $request->request->get('password');


        // Rechercher l'utilisateur dans la base de données
        $user = $entityManager->getRepository(User::class)->findOneBy([
            'email' => $email,
            'password' => $password
        ]);

        if (!$user) {
            return $this->json([
                'message' => 'Identifiants invalides'
            ], 401);
        }

        // Générer un token pour l'utilisateur
        $token = bin2hex(random_bytes(32));
        $user->setToken($token);
        $entityManager->flush();

        // Retourner le token dans une réponse JSON
        return $this->json([
            'token' => $token
        ], 200);
    }
}
