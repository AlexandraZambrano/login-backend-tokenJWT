<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class UserController extends AbstractController
{
    private $doctrine;
    
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        
        $qb = $this->doctrine->getManager()->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            // ->where('u.email LIKE :query')
            ->Where('u.email LIKE :query')
            ->setParameter('query', "%$query%");
        // var_dump($qb);
        
        $users = $qb->getQuery()->getResult();
        // var_dump($users);
        
        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                // Add more fields if needed
            ];
        }
        

        return new JsonResponse($userData);
    }
}