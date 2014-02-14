<?php

namespace H\CocktailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use H\CocktailBundle\Entity\Stat;
use H\CocktailBundle\Form\StatType;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $em     = $this->getDoctrine()->getManager();
        $entity = new Stat();
        $form   = $this->createForm(new StatType(), $entity, array(
            'action' => $this->generateUrl('index'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Envoyer',
            'attr' => array('class' => "btn btn-me")
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setApproved(0);
        
            $idCocktail = $this->algorithm(
                $em,
                $entity->getColor(),
                $entity->getAge(),
                $entity->getLangage()
            );

            $cocktail = $em->getRepository('HCocktailBundle:Cocktail')->find($idCocktail);

            $entity->setCocktail($cocktail);

            $statExiste = $em->getRepository('HCocktailBundle:Stat')->findOneBy(array(
                'color' => $entity->getColor(),
                'age' => $entity->getAge(),
                'langage' => $entity->getLangage(),
                'cocktail' => $entity->getCocktail()
                ));

            $session = new Session();

            if (! $statExiste) {
                $entity->setScore(1);
                $em->persist($entity);
                $session->getFlashBag()->add('stat', $entity->getId());
            }else{
                $statExiste->setScore($statExiste->getScore() + 1);
                $em->persist($statExiste);
                $session->getFlashBag()->add('stat', $statExiste->getId());
            }
             $em->flush();
           

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
     * @Route("/like", name="stat_like")
     * @Template("HCocktailBundle:Stat:index.html.twig") 
     */
    public function like()
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();


        // foreach ($session->getFlashBag()->get('stat', array()) as $message) {
        //     echo "<div class='flash-warning'>$message</div>";
        // }

        $statId = $session->getFlashBag()->get('stat');

        $stat = $em->getRepository('HCocktailBundle:Stat')->findById($statId);

        //$stat = $em->getRepository('HCocktailBundle:Stat')->find($session->get('stat'));
        $stat[0]->setApproved($stat[0]->getApproved() + 2);
        $stat[0]->setScore($stat[0]->getScore() + 2);

        $em->persist($stat[0]);
        $em->flush();

        return $this->redirect($this->generateUrl('index'));
    }

     /**
     * @Route("/dislike", name="stat_dislike")
     * @Template("HCocktailBundle:Stat:index.html.twig") 
     */
    public function dislike()
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $stat = $em->getRepository('HCocktailBundle:Stat')->find($session->get('stat'));
        
        $stat[0]->setApproved($stat[0]->getApproved() - 2);
        $stat[0]->setScore($stat[0]->getScore() - 3);

        $em->persist($stat[0]);
        $em->flush();

        return $this->redirect($this->generateUrl('index'));
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

    public function algorithm($em, $color, $age, $langage)
    {
        $cocktailsByColor = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'color' => $color->getId(),
        ));

        $cocktailsIdByColor = array();

        foreach ($cocktailsByColor as $stat) {
            $cocktailsIdByColor []= $stat->getId();
        }

        $cocktailsByAge = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'age' => $age->getId(),
        ));

        $cocktailsIdByAge = array();

        foreach ($cocktailsByAge as $stat) {
            $cocktailsIdByAge []= $stat->getId();
        }

        $cocktailsByLangage = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'langage' => $langage->getId(),
        ));

        $cocktailsIdByLangage = array();

        foreach ($cocktailsByLangage as $stat) {
            $cocktailsIdByLangage []= $stat->getId();
        }

        $statsIdIntersect = array();
        $statsIdIntersect = array_intersect($cocktailsIdByColor, $cocktailsIdByAge, $cocktailsIdByLangage);
        $scoreMax         = 0;
        $statScoreMax     = null;

        foreach ($statsIdIntersect as $stat) {
            $score = $em->getRepository('HCocktailBundle:Stat')->find($stat)->getScore();

            if ($score > $scoreMax && $score > 0) {
                $scoreMax     = $score;
                $statScoreMax = $stat;
            }
        }

        if (! $statScoreMax) {
            $cocktails      = $em->getRepository('HCocktailBundle:Cocktail')->findAll();
            $randomCocktail = $cocktails[array_rand($cocktails)];
            $cocktail       = $em->getRepository('HCocktailBundle:Cocktail')->find($randomcocktail->getId());
        }
        else {
            $stat     = $em->getRepository('HCocktailBundle:Stat')->find($statScoreMax);
            $cocktail = $em->getRepository('HCocktailBundle:Cocktail')->find($stat->getCocktail()->getId());
        }

        return $cocktail->getId();
    }
}
