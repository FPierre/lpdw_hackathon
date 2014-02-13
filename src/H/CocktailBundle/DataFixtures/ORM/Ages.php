<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Age;

class Ages implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ages = array(
            array('Entre 18 et 30'),
            array('Entre 30 et 40'),
            array('Entre 40 et 50'),
            array('Entre 50 et 60'),
            array('Entre 60 et 70'),
        );
        
        foreach ($ages as $age) {
            $newAge = new Age();
            
            $newAge->setName($age[0]);

            $manager->persist($newAge);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; 
    }
}