<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher=$userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker=Faker\Factory::create('fr_FR');

        for ($i=1; $i < 4; $i++) { 
            # code...
            $categorie = new Categories();
            $categorie->setName($faker->word);
            $manager->persist($categorie);
        }
       

        $manager->flush();
    }
}
