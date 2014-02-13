<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Color;

class Colors implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $colors = array(
            array('Rouge', '#FF0000'),
            array('Orange', '#FFA500'),
            array('Jaune', '#FFFF00'),
            array('Vert', '#008000'),
            array('Violet', '#800080'),
            array('Bleu', '#0000FF'),
            array('Gris', '#808080'),
            array('Noir', '#000000'),
            array('Blanc', '#FFFFFF'),
        );
        
        foreach ($colors as $color) {
            $newColor = new Color();
            
            $newColor->setName($color[0]);
            $newColor->setCode($color[1]);

            $manager->persist($newColor);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; 
    }
}