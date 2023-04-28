<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Types;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Type;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $a1 = new Articles();
        // $a1->setNom("Pomme");
        // $a1->setPrix("1");
        // $manager->persist($a1);

        // $a2 = new Articles();
        // $a2->setNom("Carotte");
        // $a2->setPrix("0.75");
        // $manager->persist($a2);

        // $a3 = new Articles();
        // $a3->setNom("Banane");
        // $a3->setPrix("0.8");
        // $manager->persist($a3);

        // $a4 = new Articles();
        // $a4->setNom("Fraise");
        // $a4->setPrix("1.05");
        // $manager->persist($a4);

        // $a5 = new Articles();
        // $a5->setNom("Poire");
        // $a5->setPrix("0.85");
        // $manager->persist($a5);
        $p1= new Types();
        $p1->setNom("fruit");
        $manager->persist($p1);
        

        $manager->flush();
    }
}
