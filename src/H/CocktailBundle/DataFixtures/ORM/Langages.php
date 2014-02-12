<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Langage;

class Langages implements FixtureInterface
{

	public function load(ObjectManager $manager)
    {

    	$aLangages = array('Php', 'Cobol', 'C#', 'Javascript', 'Java', 'Basic', 'Ruby', 'Python', 'C++', 'Objective C', 'ASP');

    	foreach ($aLangages as $key => $aLangage) {

            $langage = new Langage();
            $langage->setName($aLangage);

            $manager->persist($langage);

        }

        $manager->flush();

    }


}