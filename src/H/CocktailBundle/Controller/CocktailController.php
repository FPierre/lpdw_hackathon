<?php

namespace H\CocktailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use H\CocktailBundle\Entity\Cocktail;
use H\CocktailBundle\Form\CocktailType;

/**
 * Cocktail controller.
 *
 * @Route("/cocktail")
 */
class CocktailController extends Controller
{

    /**
     * Lists all Cocktail entities.
     *
     * @Route("/", name="cocktail")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HCocktailBundle:Cocktail')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cocktail entity.
     *
     * @Route("/", name="cocktail_create")
     * @Method("POST")
     * @Template("HCocktailBundle:Cocktail:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cocktail();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cocktail_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Cocktail entity.
    *
    * @param Cocktail $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Cocktail $entity)
    {
        $form = $this->createForm(new CocktailType(), $entity, array(
            'action' => $this->generateUrl('cocktail_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cocktail entity.
     *
     * @Route("/new", name="cocktail_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cocktail();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cocktail entity.
     *
     * @Route("/{id}", name="cocktail_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Cocktail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cocktail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cocktail entity.
     *
     * @Route("/{id}/edit", name="cocktail_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Cocktail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cocktail entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Cocktail entity.
    *
    * @param Cocktail $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cocktail $entity)
    {
        $form = $this->createForm(new CocktailType(), $entity, array(
            'action' => $this->generateUrl('cocktail_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cocktail entity.
     *
     * @Route("/{id}", name="cocktail_update")
     * @Method("PUT")
     * @Template("HCocktailBundle:Cocktail:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Cocktail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cocktail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cocktail_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cocktail entity.
     *
     * @Route("/{id}", name="cocktail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HCocktailBundle:Cocktail')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cocktail entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cocktail'));
    }

    /**
     * Creates a form to delete a Cocktail entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cocktail_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
