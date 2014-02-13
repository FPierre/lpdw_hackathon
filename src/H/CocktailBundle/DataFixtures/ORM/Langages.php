<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Langage;

class Langages implements FixtureInterface, OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
    {
    	$langages = array(
            'PHP', 'Cobol', 'C#', 'Javascript', 
            'Java', 'Basic', 'Ruby', 'Python', 
            'C++', 'Objective C', 'ASP'
        );

    	foreach ($langages as $langage) {
            $newLangage = new Langage();
            
            $newLangage->setName($langage);

            $manager->persist($newLangage);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4; 
    }
}