<?php

namespace H\CocktailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use H\CocktailBundle\Entity\Stat;
use H\CocktailBundle\Form\StatType;

// "/stat"
class StatController extends Controller
{
    /**
     * Display the form
     *
     * @Route("/", name="index")
     * @Template("HCocktailBundle:Stat:index.html.twig")
     */
    // "stat" et "GET"
    public function indexAction(Request $request)
    {
        $entity = new Stat();
        $form = $this->createForm(new StatType(), $entity, array(
            'action' => $this->generateUrl('index'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'envoyer',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setApproved(0);
            $entity->setScore(0);

            // $em->persist($entity);
            // $em->flush();

            $idCocktail = $this->algorithm(
                $entity->getColor(),
                $entity->getAge(),
                $entity->getLangage()
            );

            return $this->redirect($this->generateUrl('stat_show', array(
                'id' => $idCocktail,
            )));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="stat_show")
     * @Method("GET")
     * @Template("HCocktailBundle:Stat:show.html.twig") 
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('HCocktailBundle:Cocktail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cocktail entity.');
        } 
        else {
            $ingredient = $em->getRepository('HCocktailBundle:CocktailIngredient')->findByCocktail($entity);
        }

        return array(
            'entity'      => $entity,
            'ingredient'  => $ingredient,
        );
    }

    public function algorithm($color, $age, $langage)
    {
        $em = $this->getDoctrine()->getManager();

        $statCocktailsColor = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'color' => $color->getId(),
        ));
        $statCocktailsAge = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'age' => $age->getId(),
        ));
        $statCocktailsLangage = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'langage' => $langage->getId(),
        ));

        $statColorId = array();

        foreach ($statCocktailsColor as $stat) {
            $statColorId []= $stat->getId();
        }

        $statAgeId = array();

        foreach ($statCocktailsAge as $stat) {
            $statAgeId []= $stat->getId();
        }

        $statLangageId = array();

        foreach ($statCocktailsLangage as $stat) {
            $statLangageId []= $stat->getId();
        }

        $statId = array_intersect($statColorId, $statAgeId, $statLangageId);
        $scoreMax = 0;
        $statScoreMax = null;

        foreach ($statId as $stat) {
            $score = $em->getRepository('HCocktailBundle:Stat')->find($stat)->getScore();

            if ($score > $scoreMax) {
                $scoreMax = $score;
                $statScoreMax = $stat;
            }
        }

        if (! $statScoreMax) {
            $cocktails = $em->getRepository('HCocktailBundle:Cocktail')->findAll();
            $randomcocktail   = $cocktails[array_rand($cocktails)];
            $cocktail      = $em->getRepository('HCocktailBundle:Cocktail')->find($randomcocktail->getId());
        }
        else {
            $stat = $em->getRepository('HCocktailBundle:Stat')->find($statScoreMax);
            $cocktail = $em->getRepository('HCocktailBundle:Cocktail')->find($stat->getCocktail()->getId());
        }

        return $cocktail->getId();
    }
}
