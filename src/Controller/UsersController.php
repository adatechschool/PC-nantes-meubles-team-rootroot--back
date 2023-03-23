<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use Psr\Log\LoggerInterface;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    //route qui retourne tous les users
    #[Route('/get_all_users', name: 'get_users', methods: 'GET')]
    public function getUsers(ManagerRegistry $doctrine): Response
    {
        // Get all Users entities from the database
        $users = $doctrine
            ->getRepository(Users::class)
            ->findAll();
        // Initialize an empty array to store data for each Users entity
        $data = [];
        // Loop through each Users entity and add its data to the $data array, but only specific fields
        foreach ($users as $user) {
            $data[] = [
                'id' => $user ->getId(),
                'name' => $user ->getName(),
                'email' => $user ->getEmail(),
                'password'=> $user ->getPassword(),
                'role'=> $user ->getRole(),
            ];
        }
        // Return the $data array as a JSON response
        return $this->json($data);
    }

    //route qui permet de créer un user
        #[Route('/post_user', name: 'post_user', methods: 'POST')]
        public function new (ManagerRegistry $doctrine, Request $request, LoggerInterface $logger)
        {
            // Get the Doctrine entity manager
            $entityManager = $doctrine->getManager();
    
            $user = new Users();
    
            // Get the request data as an array
            $data = json_decode($request->getContent(), true);
            // Replace the request data with the array data
            $request->request->replace($data);
    
            // Set the properties of the new Users entity using the request data
    
            $user->setName($request->request->get('name'));
            $user->setEmail($request->request->get('email'));
            $user->setPassword($request->request->get('password'));
            $user->setRole($request->request->get('role'));
    
            //tells the Doctrine ORM to track and save the $user object to the database when the flush() method is called.
            $entityManager->persist($user);
            //saves any changes made to managed entities to the database.
            $entityManager->flush();
    
            return $this->json('Created new user successfully with id ' . $user->getId());
        }

    //route qui permet de verifier si c'est bien l'admin (si oui, renvoie true)
    #[Route('/get_admin/{email}/{password}', name: 'get_admin', methods: 'GET')]
    public function getUserIfAdmin(string $email, string $password, ManagerRegistry $doctrine): Response
    {
        $user = $doctrine
          ->getRepository(Users::class)
          ->findOneBy(['email' => $email, 'password' => $password]);
        if (!$user) {
            // Return a 404 response if the email does not exist 
            throw $this->createNotFoundException('There is no user with this mail or password.');
        }
        // Initialize an empty array to store data for response object 
        $data = [];
        //check if role is admin or not
        if($user->getRole() === 'Admin') {
            $data[] = [
                'isAdmin'=>true,
            ];
        } else {
            throw $this->createNotFoundException('This user is not an admin!');
        }
        return $this->json($data);
    }
}

