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
        
        foreach ($cocktails as $cocktail) {

            var_dump($cocktail->getName());

            $randomColor   = $colors[array_rand($colors)];
            $newColor      = $manager->getRepository('HCocktailBundle:Color')->find($randomColor->getId());

            $randomAge     = $ages[array_rand($ages)];
            $newAge        = $manager->getRepository('HCocktailBundle:Age')->find($randomAge->getId());

            $newCocktail   = $manager->getRepository('HCocktailBundle:Cocktail')->find($cocktail->getId());
            // nom du cocktail
            $cocktailName = $newCocktail->getName();

            // Tous les ingredients
            $allLanguages = $manager->getRepository('HCocktailBundle:Langage')->findAll();

            $theLanguage = '';
            $memory = 0;
            foreach ($allLanguages as $oneLanguage) {

                $count = similar_text($oneLanguage->getName(), $cocktailName);
                if($count > $memory){
                    $memory = $count;
                    $theLanguage = $oneLanguage;
                }

            }

            if($theLanguage == ''){
                $randomLanguage   = $langages[array_rand($langages)];
                $theLanguage = $manager->getRepository('HCocktailBundle:Langage')->find($randomLanguage->getId());
            }
            var_dump($theLanguage);

            // nom Ingredient
            $newStat = new Stat();
            $newStat->setColor($newColor);
            $newStat->setAge($newAge);
            $newStat->setLangage($theLanguage);
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