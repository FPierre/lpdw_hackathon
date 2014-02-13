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

        //$cocktails = $this->csvToArray('/Users/LEI/Projects/LPDW/PHP/Symfony/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        //$cocktails = $this->csvToArray('/var/www/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        $cocktails = $this->csvToArray('/Users/aureliendumont/SiteWeb/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');

        // Cocktail & Ingredient
        $colors = array('#a66bbe', '#008da3', '#e97b7d', '#b14151');
        foreach ($cocktails as $name => $c) {

            $cocktail = new Cocktail();
            $cocktail->setName($name);
            $cocktail->setcomment('Lorem');

            foreach ($c as $theIngredient => $theProp) {

                $em = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $em->findOneByName($theIngredient);

                if (!$ingredient) {

                    $ingredient = new Ingredient();
                    $ingredient->setName($theIngredient);
                    $ingredient->setColor($colors[rand(0,3)]);

                    $manager->persist($ingredient);

                    $manager->flush();
                }
            }
        }

        // CocktailIngredient
        foreach ($cocktails as $name => $c) {

            $em = $manager->getRepository('HCocktailBundle:Cocktail');
            $cocktail = $em->findOneByName($name);

            foreach ($c as $ingredient => $proportion) {

                $em = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $em->findOneByName($ingredient);

                $cocktailIngredient = new CocktailIngredient();
                $cocktailIngredient->setCocktail($cocktail);
                $cocktailIngredient->setIngredient($ingredient);
                $cocktailIngredient->setProportion($proportion);

                $manager->persist($cocktailIngredient);
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
                $name = ucfirst($oneData['nom']);
                $result[$name] = array();
                $result[$name][ucfirst($oneData['ingrédients'])] = substr($oneData['proportions'], 0);
                //$result[$name]['proportion'][] = $oneData['proportions'];
            }else{
                $result[$name][ucfirst($oneData['ingrédients'])] = substr($oneData['proportions'], 0);
            }

        }
        return $result;
    }
}