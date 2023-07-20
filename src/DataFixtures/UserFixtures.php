<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $contributor = new User();
        $contributor->setEmail('lionel.darosa@hotmail.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($contributor, 'password'));

        $manager->persist($contributor);
        $manager->flush();
    }
}
