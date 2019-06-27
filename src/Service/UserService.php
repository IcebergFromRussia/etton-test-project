<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 28.06.2019
 * Time: 1:29
 */

namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUserByLogPassName($login, $password, $name){

        $user = new User();
        $user   ->setLogin($login)
            ->setPassword($this->passwordEncoder->encodePassword($user, $password))
            ->setName($name);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}