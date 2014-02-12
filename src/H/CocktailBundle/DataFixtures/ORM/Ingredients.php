<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Cocktail;
use H\CocktailBundle\Entity\Ingredient;
use H\CocktailBundle\Entity\CocktailIngredient;

class Ingred implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $AllCocktails = $this->csvToArray('/Users/LEI/Projects/LPDW/PHP/Symfony/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');


        $colors = array('#a66bbe', '#008da3', '#e97b7d', '#b14151');
        foreach ($AllCocktails as $name => $oneCocktail) {

            $cocktail = new Cocktail();
            $cocktail->setName($name);
            $cocktail->setcomment('Lorem');

            foreach ($oneCocktail as $theIngredient => $theProp) {

                $mIngred = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $mIngred->findByName($theIngredient);

                if (!$ingredient) {
                    $ingredient = new Ingredient();
                    $ingredient->setName($theIngredient);

                    $i = rand(0,3);
                    $ingredient->setColor($colors[$i]);
                    $manager->persist($ingredient);

                    $manager->flush();
                }
            }
        }
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
                $name = $oneData['nom'];
                $result[$name] = array();
                $result[$name][ucfirst($oneData['ingrédients'])] = $oneData['proportions'];
                //$result[$name]['proportion'][] = $oneData['proportions'];
            }else{
                $result[$name][ucfirst($oneData['ingrédients'])] = $oneData['proportions'];
            }

        }
        return $result;
    }
}