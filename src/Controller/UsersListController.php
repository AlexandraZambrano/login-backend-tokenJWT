<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class UsersListController extends AbstractController
{
    #[Route('/dashboard/users/list', name: 'app_users_list', methods:'GET' )]
    public function usersList(ManagerRegistry $doctrine): Response
    {
        $user = $doctrine
        ->getRepository(User::class)
        ->findAll();

        foreach ($user as $users) {
            $data[] = [
                'id' => $users->getId(),
                'username' => $users->getUsername(),
            ];
        }

        $datanueva =  json_encode($data);

        
        $response = new Response($datanueva);

        $response->headers->add([
            'Content-Type' => 'application/json'
        ]);

        return $response;
    }
}
