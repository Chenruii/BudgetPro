<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class UserController extends  AbstractFOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository,EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }
    /**
     * @Rest\Get("api/users/{email}")
     */
    public function getOneUser(User $user){}

    /**
     * @Rest\Get("api/users")
     */
    public function getAllUsers(){}

    /**
     * @Rest\Post("api/users/{email}")
     */
    public function PosttApiUser(User $user){}

    /**
     * @Rest\Patch("api/users/{email}")
     */
    public function PatchApiUser(User $user){}

    /**
     * @Rest\Delete("api/users/{email}")
     */
    public function DeleteApiUser(User $user){}
}
