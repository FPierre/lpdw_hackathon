<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Stat;
use H\CocktailBundle\Entity\Age;
use H\CocktailBundle\Entity\Langage;
use H\CocktailBundle\Entity\Cocktail;

class Stats implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ages      = $manager->getRepository('HCocktailBundle:Age')->findAll();
        $colors    = $manager->getRepository('HCocktailBundle:Color')->findAll();
        $langages  = $manager->getRepository('HCocktailBundle:Langage')->findAll();
        $cocktails = $manager->getRepository('HCocktailBundle:Cocktail')->findAll();
        
        //var_dump($ages[0]->getId());

        // exit(0);

        foreach ($cocktails as $cocktail) {
            $randomColor   = $colors[array_rand($colors)];
            $newColor      = $manager->getRepository('HCocktailBundle:Color')->find($randomColor->getId());
            $randomAge     = $ages[array_rand($ages)];
            $newAge        = $manager->getRepository('HCocktailBundle:Age')->find($randomAge->getId());
            $randomLangage = $langages[array_rand($langages)];
            $newLangage    = $manager->getRepository('HCocktailBundle:Langage')->find($randomLangage->getId());
            $newCocktail   = $manager->getRepository('HCocktailBundle:Cocktail')->find($cocktail->getId());
            $newStat       = new Stat();

            $newStat->setColor($newColor);
            $newStat->setAge($newAge);
            $newStat->setLangage($newLangage);
            $newStat->setCocktail($newCocktail);
            $newStat->setApproved(1);
            $newStat->setScore(2);

            $manager->persist($newStat);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5; 
    }
}