<?php

namespace H\CocktailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use H\CocktailBundle\Entity\Langage;
use H\CocktailBundle\Form\LangageType;

/**
 * Langage controller.
 *
 * @Route("/langage")
 */
class LangageController extends Controller
{

    /**
     * Lists all Langage entities.
     *
     * @Route("/", name="langage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HCocktailBundle:Langage')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Langage entity.
     *
     * @Route("/", name="langage_create")
     * @Method("POST")
     * @Template("HCocktailBundle:Langage:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Langage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('langage_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Langage entity.
    *
    * @param Langage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Langage $entity)
    {
        $form = $this->createForm(new LangageType(), $entity, array(
            'action' => $this->generateUrl('langage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Langage entity.
     *
     * @Route("/new", name="langage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Langage();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Langage entity.
     *
     * @Route("/{id}", name="langage_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Langage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Langage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Langage entity.
     *
     * @Route("/{id}/edit", name="langage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Langage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Langage entity.');
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
    * Creates a form to edit a Langage entity.
    *
    * @param Langage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Langage $entity)
    {
        $form = $this->createForm(new LangageType(), $entity, array(
            'action' => $this->generateUrl('langage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Langage entity.
     *
     * @Route("/{id}", name="langage_update")
     * @Method("PUT")
     * @Template("HCocktailBundle:Langage:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Langage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Langage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('langage_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Langage entity.
     *
     * @Route("/{id}", name="langage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HCocktailBundle:Langage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Langage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('langage'));
    }

    /**
     * Creates a form to delete a Langage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('langage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
