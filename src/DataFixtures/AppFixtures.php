<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{  
    private Generator $faker;
    
    public function __construct()
    {
       $this->faker = Factory::create('en_EN');
    }
    public function load(ObjectManager $manager): void
    {
        $users = [];
        for( $i=0 ;  $i<5 ;$i++ ){   
          $user = new user();
          $user->setFirstName($this->faker->firstname());
          $user->setLastName($this->faker->lastname());
          $user->setAddress($this->faker->address());
           $user->setEmail($this->faker->email());
           $user->setRoles(['ROLE_USER']);
           $user->setPlainPassword('password');
           $user->setBio($this->faker->realText($maxNbChars = 150, $indexSize = 2));
           $users[] = $user;
           $manager->persist($user);
        }
        $articles = [];
        for( $i=0 ;  $i<100 ;$i++ ){   
        $article = new Article();
        $article->setTitle('the last Technologes');
        $article->setContent($this->faker->realText($maxNbChars = 5000, $indexSize = 2));
        $article->setCategory('Programming');
        $article->setUser($users[mt_rand(0 , count($users) -1 )]);
        $articles[] = $article;
        $manager->persist($article);
    }
        
  
       
        $manager->flush();
    }
}
