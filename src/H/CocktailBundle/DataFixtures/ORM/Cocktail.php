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

        $AllCocktails = $this->csvToArray('/Users/aureliendumont/SiteWeb/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');


        $colors = array('#a66bbe', '#008da3', '#e97b7d', '#b14151');
        foreach ($AllCocktails as $name => $oneCocktail) {

            $cocktail = new Cocktail();
            $cocktail->setName($name);
            $cocktail->setcomment('Lorem');

            $manager->persist($cocktail);

            foreach ($oneCocktail as $theIngredient => $theProp) {

                $ingredient = new Ingredient();
                $ingredient->setName($theIngredient);

                $i = rand(0,3);
                $ingredient->setColor($colors[$i]);

                $manager->persist($ingredient);

                $cocktailIngredient = new CocktailIngredient();
                $cocktailIngredient->setProportion($theProp);

                $cocktailIngredient->setCocktail($cocktail);
                $cocktailIngredient->setIngredient($ingredient);

                //$manager->persist($cocktailIngredient);

            }

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
                $name = $oneData['nom'];
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