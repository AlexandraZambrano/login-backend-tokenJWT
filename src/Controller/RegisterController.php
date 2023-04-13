<?php

namespace App\Controller;

use App\Entity\User;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'register', methods:'POST')]
    public function register(Request $request, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['username']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));


        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(['success' => true]);


    }
}
