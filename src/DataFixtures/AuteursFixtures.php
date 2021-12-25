<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class AuteursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Faker\Factory::create('fr_FR');
        for ($i=1;$i<=20;$i++){
            $auteur = new Auteur();
            $auteur->setNomPrenom($faker->name);
            $auteur->setSexe(array_rand(array("M"=>"male","F"=>"female")));
            $auteur->setDateDeNaissance($faker->dateTime($format = 'Y-m-d', $max = '2016-06-09'));
            $auteur->setNationalite($faker->countryCode);
            $manager->persist($auteur);
            //Enregistrer les references de tel sorte qu'on peut les appeler plutard
            $this->addReference('auteur_'.$i,$auteur);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
