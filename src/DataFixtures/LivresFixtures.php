<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class LivresFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Faker\Factory::create('fr_FR');
        for($i=1 ; $i<=50 ; $i++){
            $book= new Livre();
            for($j=1;$j<=$faker->numberBetween(1,2);$j++){
                $book->addAuteur($this->getReference('auteur_'.$faker->numberBetween(1,20)));
            }
            for($j=1;$j<=$faker->numberBetween(1,2);$j++){
                $book->addGenre($this->getReference('genre_'.$faker->numberBetween(1,10)));
            }
            $book->setIsbn($faker->isbn13);
            $book->setTitre($faker->realText(25));
            $book->setDateDeParution($faker->dateTimeBetween($startDate = '1900-01-01', $endDate = '2021-01-01', $timezone = null));
            $book->setNombrePages($faker->numberBetween($min = 3,$max=1000));
            $book->setNote($faker->numberBetween($min = 0,$max=20));
            
            $manager->persist($book);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
