<?php

namespace App\DataFixtures;


use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $genre = new Genre();
        $genre->setNom("Horror");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Adventure");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Sport");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Romance");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Science Fiction");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Documentary");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Encyclopedia");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Manga");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Bande Déssinée");
        $manager->persist($genre);
        $genre = new Genre();
        $genre->setNom("Crime");
        $manager->persist($genre);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
