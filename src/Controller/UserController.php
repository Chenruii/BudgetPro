<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function getOneUser(User $user)
    {
        return $this->json($user);
    }

    /**
     * @Rest\Get("api/users")
     */
    public function getAllUsers()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);
    }

    /**
     * @Rest\Post("api/users/{email}")
     */
    public function PosttApiUser(User $user){}

    /**
     * @Rest\Patch("api/users/{email}")
     */
    public function PatchApiUser( Request $request, User $user,ValidatorInterface $validator )
    {
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $address = $request->get('address');
        $country = $request->get('country');
        $cards = $request->get('card');
        $subscription  = $request->get('subscription');

        if (null !== $firstname ){
            $user->setFirstname($firstname);
        }
        if (null !== $lastname){
            $user->setLastname($lastname);
        }
        if (null !== $address){
            $user->setAddress($address);
        }
        if (null !== $country){
            $user->setCountry($country);
        }
        if (null !== $cards){
            $user->setCard($cards);
        }
        if (null !== $subscription){
            $user->setUsers($subscription);
        }

        $validationErrors =$validator->validate($user);
        if ($validationErrors->count() > 0){
            foreach ($validationErrors as $constraintViolation ){
                // Returns the violation message. (Ex. This value should not be blank.) $message = $constraintViolation ->getMessage(); // Returns the property path from the root element to the violation. (Ex. lastname
                $message = $constraintViolation ->getMessage();
                // Returns the property path from the root element to the violation. (Ex. lastname)
                $propertyPath = $constraintViolation ->getPropertyPath();
                $errors[] = ['message' => $message, 'propertyPath' => $propertyPath];
            }
        }
        if (!empty($errors)){
            // Throw a 400 Bad Request with all errors messages (Not readable, you can do better)
            throw new BadRequestHttpException(\json_encode( $errors));
        }
        $this->em->persist($user);
        $this->em->flush();

        return $this->json($user);
    }

    /**
     * @Rest\Delete("api/users/{email}")
     */
    public function DeleteApiUser(User $user){}
}
