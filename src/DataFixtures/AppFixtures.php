<?php

namespace App\DataFixtures;
use App\Entity\Category;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->company);
            $manager->persist($category);
            $this->createBook($manager, $category, $faker);
        }
        $manager->flush();
    }

    private function createBook(ObjectManager $manager, Category $category , \Faker\Generator $faker) {
        for ($j = 0; $j < 10; $j++) {
            $book = new Book();
            $book->setCode($faker->numberBetween($min = 1000, $max = 9000) );
            $book->setTitle($faker->company);
            $book->setAuthor($faker->name);
            $book->setAbstract($faker->text($maxNbChars = 200));
            $book->setCategory($category);
            $manager->persist($book);
        }
    }
}
