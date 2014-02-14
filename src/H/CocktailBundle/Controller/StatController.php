<?php

namespace H\CocktailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use H\CocktailBundle\Entity\Stat;
use H\CocktailBundle\Form\StatType;

/**
 * Stat controller.
 *
 * @Route("/stat")
 */
class StatController extends Controller
{
    /**
     * Lists all Stat entities.
     *
     * @Route("/", name="stat")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * Creates a new Stat entity.
     *
     * @Route("/", name="stat_create")
     * @Method("POST")
     * @Template("HCocktailBundle:Stat:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Stat();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setApproved(0);
            $entity->setScore(0);

            //$em->persist($entity);
            //$em->flush();

            $cocktail = $this->algorithm(
                $entity->getColor(),
                $entity->getAge(),
                $entity->getLangage()
            );

            return $this->redirect($this->generateUrl('stat_show', array(
                'id' => $cocktail,
            )));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
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

        $stat = $em->getRepository('HCocktailBundle:Stat')->find($statScoreMax);
        $cocktail = $em->getRepository('HCocktailBundle:Cocktail')->find($stat->getCocktail()->getId());

        return $cocktail->getId();
    }

    /**
    * Creates a form to create a Stat entity.
    *
    * @param Stat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Stat $entity)
    {
        $form = $this->createForm(new StatType(), $entity, array(
            'action' => $this->generateUrl('stat_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'envoyer', 'attr' => array('class' => 'btn btn-me')));

        return $form;
    }

    /**
     * Displays a form to create a new Stat entity.
     *
     * @Route("/new", name="stat_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Stat();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Stat entity.
     *
     * @Route("/{id}", name="stat_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        if (! $entity) {
            throw $this->createNotFoundException('Unable to find Stat entity.');
        }

        return array(
            'cocktail' => $cocktail,
        );
    }
}
