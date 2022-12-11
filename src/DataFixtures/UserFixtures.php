<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private Generator $faker;

    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
     $this->faker = Factory::create('en_EN');
     $this->hasher= $hasher;
    }
    public function load(ObjectManager $manager , ): void
    {
       

        for( $i=0 ;  $i<5 ;$i++ ){   
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setRoles(['ROLE_USER']);
             $hasherPassword = $this->hasher->hashPassword(
                $user,
                'password'
             );

            $user->setPassword($hasherPassword);
           
         $manager->persist($user);
        }
        $manager->flush();
    }
}
