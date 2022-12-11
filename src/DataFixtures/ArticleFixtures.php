<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ArticleFixtures extends Fixture
{
    private Generator $faker;
    
    public function __construct()
    {
       $this->faker = Factory::create('en_EN');
    }


    public function load(ObjectManager $manager): void
    {
        for( $i=0 ;  $i<5 ;$i++ ){   
        $article = new Article();
        $article->setTitle('the last Technologes');
        $article->setContent($this->faker->realText($maxNbChars = 250));
        $article->setCategory('programation');
        $manager->persist($article);
    }
        $manager->flush();
    }
}
