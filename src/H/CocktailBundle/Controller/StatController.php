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
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stat_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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

        $form->add('submit', 'submit', array('label' => 'Create'));

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
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Stat entity.
     *
     * @Route("/{id}/edit", name="stat_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Stat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stat entity.');
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
    * Creates a form to edit a Stat entity.
    *
    * @param Stat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Stat $entity)
    {
        $form = $this->createForm(new StatType(), $entity, array(
            'action' => $this->generateUrl('stat_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Stat entity.
     *
     * @Route("/{id}", name="stat_update")
     * @Method("PUT")
     * @Template("HCocktailBundle:Stat:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Stat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('stat_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Stat entity.
     *
     * @Route("/{id}", name="stat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HCocktailBundle:Stat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Stat entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stat'));
    }

    /**
     * Creates a form to delete a Stat entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stat_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
