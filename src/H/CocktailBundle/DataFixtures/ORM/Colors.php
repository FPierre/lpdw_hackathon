<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Color;

class Colors implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $colors = array(
            array('red', '#FF0000'),
            array('orange', '#FFA500'),
            array('yellow', '#FFFF00'),
            array('green', '#008000'),
            array('purple', '#800080'),
            array('blue', '#0000FF'),
            array('grey', '#808080'),
            array('black', '#000000'),
            array('white', '#FFFFFF'),
        );

        foreach ($colors as $color) {
            $newColor = new Color();

            $newColor->setName($color[0]);
            $newColor->setCode($color[1]);

            $manager->persist($newColor);
        }

        $manager->flush();
    }
}