<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Age;

class Ages implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ages = array(
            array('Inférieur à 10'),
            array('Entre 10 et 20'),
            array('Entre 20 et 30'),
            array('Entre 30 et 40'),
            array('Entre 40 et 50'),
            array('Entre 50 et 60'),
            array('Entre 60 et 70'),
            array('Entre 70 et 80'),
            array('Entre 80 et 90'),
        );
        
        foreach ($ages as $age) {
            $newAge = new Age();
            
            $newAge->setName($age[0]);

            $manager->persist($newAge);
        }

        $manager->flush();
    }
}