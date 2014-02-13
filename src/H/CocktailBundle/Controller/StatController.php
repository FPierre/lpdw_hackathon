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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HCocktailBundle:Stat')->findAll();

        return array(
            'entities' => $entities,
        );
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

            $this->algorithm(
                $entity->getColor(),
                $entity->getAge(),
                $entity->getLangage()
            );

            return $this->redirect($this->generateUrl('stat_show', array(
                'id' => $entity->getId()
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

        $cocktailsColor = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'color' => $color->getId(),
        ));
        $cocktailsAge = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'age' => $age->getId(),
        ));
        $cocktailsLangage = $em->getRepository('HCocktailBundle:Stat')->findBy(array(
            'langage' => $langage->getId(),
        ));

        $cocktailsColorId = array();

        foreach ($cocktailsColor as $cocktail) {
            $cocktailsColorId []= $cocktail->getId();
        }

        $cocktailsAgeId = array();

        foreach ($cocktailsAge as $cocktail) {
            $cocktailsAgeId []= $cocktail->getId();
        }

        $cocktailsLangageId = array();

        foreach ($cocktailsLangage as $cocktail) {
            $cocktailsLangageId []= $cocktail->getId();
        }

        $cocktails = array_intersect_assoc($cocktailsColorId, $cocktailsAgeId, $cocktailsLangageId);

        var_dump($cocktails);
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Stat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
        );
    }

    public function editAction($id)
    {
    }

    private function createEditForm(Stat $entity)
    {
    }

    public function updateAction(Request $request, $id)
    {
    }

    public function deleteAction(Request $request, $id)
    {
    }

    private function createDeleteForm($id)
    {
    }
}
