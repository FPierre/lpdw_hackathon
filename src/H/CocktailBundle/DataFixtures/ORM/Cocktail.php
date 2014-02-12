<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Cocktail;
use H\CocktailBundle\Entity\Ingredient;
use H\CocktailBundle\Entity\CocktailIngredient;

class Cocktails implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $AllCocktails = $this->csvToArray('/var/www/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        foreach ($AllCocktails as $name => $oneCocktail) {

            $cocktail = new Cocktail();
            $cocktail->setName($name);
            $cocktail->setcomment('Lorem');

            $manager->persist($cocktail);

        }

        $manager->flush();
    }

    public function csvToArray($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $allDatas = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                //var_dump($row);
                if(!$header)
                    $header = $row;
                else
                    $allDatas[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        $result = array();
        $name = '';
        foreach ($allDatas as $key => $oneData) {

            if($oneData['nom'] != ''){
                $name = ucfirst($oneData['nom']);
                $result[$name] = array();
                $result[$name][$oneData['ingrédients']] = $oneData['proportions'];
                //$result[$name]['proportion'][] = $oneData['proportions'];
            }else{
                $result[$name][$oneData['ingrédients']] = $oneData['proportions'];
            }

        }
        return $result;
    }
}