<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Cocktail;
use H\CocktailBundle\Entity\Ingredient;
use H\CocktailBundle\Entity\CocktailIngredient;

class Cocktails implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        //$cocktails = $this->csvToArray('/Users/LEI/Projects/LPDW/PHP/Symfony/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        //$cocktails = $this->csvToArray('/var/www/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        //$cocktails = $this->csvToArray('/Users/aureliendumont/SiteWeb/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');

        // Cocktail & Ingredient
        foreach ($cocktails as $name => $c) {

            $cocktail = new Cocktail();
            $cocktail->setName($name);
            $cocktail->setcomment('Lorem');

            foreach ($c as $ingredientName => $proportion) {

                $em = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $em->findOneByName($ingredientName);

                if (!$ingredient) {

                    $ingredient = new Ingredient();
                    $ingredient->setName($ingredientName);

                    $color = $this->getMainColor($ingredientName);
                    $ingredient->setColor($color);

                    //echo $color . ' ' . $ingredientName . ' - ';

                    $manager->persist($ingredient);

                    $manager->flush();
                }
            }
        }

        // CocktailIngredient
        foreach ($cocktails as $name => $c) {

            $em = $manager->getRepository('HCocktailBundle:Cocktail');
            $cocktail = $em->findOneByName($name);

            foreach ($c as $ingredientName => $proportion) {

                $em = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $em->findOneByName($ingredientName);

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

    function getGoogleImage($query) {
        // The request also includes the userip parameter which provides the end
        // user's IP address. Doing so will help distinguish this legitimate
        // server-side traffic from traffic which doesn't come from an end-user.
        $url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . $query .
            "&userip=194.167.235.232&imgc=color&as_filetype=jpg";

        // sendRequest
        // note how referer is set manually
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 'http://images.google.com/');
        $body = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($body);

        $imageUrl = $json->responseData->results[0]->url;
        //echo '<img src="'.$imageUrl.'" />';

        return $imageUrl;
    }

    function getResource($url)
    {
        preg_match('/\.[^.]*$/', $url, $matches);
        $ext = $matches[0];

        if ($ext == '.jpg' | $ext == '.jpeg') {
            $image = imagecreatefromjpeg($url);
        } else if ($ext == '.png') {
            $image = imagecreatefrompng($url);
        } else if ($ext == '.gif') {
            $image = imagecreatefromgif($url);
        } else {
            return false;
        }

        return $image;
    }

    function averageColor($image)
    {
        $width = imagesx($image);
        $height = imagesy($image);

        $pixel = imagecreatetruecolor(1, 1);
        imagecopyresampled($pixel, $image, 0, 0, 0, 0, 1, 1, $width, $height);
        $rgb = imagecolorat($pixel, 0, 0);
        $color = imagecolorsforindex($pixel, $rgb);

        return $color;
    }

    function toRgb($color) {
        $rgb = 'rgb(' . $color['red'] . ',' . $color['green'] . ',' . $color['blue'] . ')';

        return $rgb;
    }

    function toHex($R, $G, $B){
        $R=dechex($R);
        If (strlen($R)<2)
        $R='0'.$R;

        $G=dechex($G);
        If (strlen($G)<2)
        $G='0'.$G;

        $B=dechex($B);
        If (strlen($B)<2)
        $B='0'.$B;

        return '#' . $R . $G . $B;
    }

    function getMainColor($search) {

        $q = urlencode($search);
        $url = $this->getGoogleImage($q);

        $res = $this->getResource($url);

        if ($res) {
            $color = $this->averageColor($res);
            if ($color) {
                 //$rgb = $this->toRgb($color);
                 $hex = $this->toHex($color['red'], $color['green'], $color['blue']);
            } else {
                $hex = '#000';
            }
        } else {
            $hex = '#fff';
        }

        // echo '<p style="background-color: ' . $rgb . ';">' . $hex . '</p>';
        return $hex;
    }

    public function getOrder()
    {
        return 1; 
    }
}