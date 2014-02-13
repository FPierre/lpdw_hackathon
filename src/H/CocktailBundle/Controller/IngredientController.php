<?php

namespace H\CocktailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use H\CocktailBundle\Entity\Ingredient;
use H\CocktailBundle\Form\IngredientType;

/**
 * Ingredient controller.
 *
 * @Route("/ingredient")
 */
class IngredientController extends Controller
{

    /**
     * Lists all Ingredient entities.
     *
     * @Route("/", name="ingredient")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        function getGoogleImage($query) {
            $url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . $query .
                "&userip=194.167.235.232&imgc=color&as_filetype=jpg&imgsz=small|medium";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, 'http://google.com/');
            $body = curl_exec($ch);
            curl_close($ch);

            $json = json_decode($body);

            if ($json) {
                $imageUrl = $json->responseData->results[0]->url;
                //echo '<img src="'.$imageUrl.'" />';
            } else {
                return false;
            }

            return $imageUrl;
        }

        function getResource($url)
        {
            preg_match('/\.[^.]*$/', $url, $matches);
            $ext = $matches[0];

            if ($ext == '.jpg' | $ext == '.jpeg') {
                $image = @imagecreatefromjpeg($url);
            } else if ($ext == '.png') {
                $image = @imagecreatefrompng($url);
            } else if ($ext == '.gif') {
                $image = @imagecreatefromgif($url);
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
            $url = getGoogleImage($q);

            if ($url) {
                $res = getResource($url);
            } else {
                $hex = '#';
            }

            if ($res) {
                $color = averageColor($res);
                if ($color) {
                     //$rgb = $this->toRgb($color);
                     $hex = toHex($color['red'], $color['green'], $color['blue']);
                } else {
                    $hex = '#000';
                }
            } else {
                $hex = '#fff';
            }

            // echo '<p style="background-color: ' . $rgb . ';">' . $hex . '</p>';
            return $hex;
        }

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('HCocktailBundle:Ingredient')->findAll();

        $i = array();
        foreach ($entities as $e) {
            $name = $e->getName();
            $i[$name] = getMainColor($name);
        }

        //var_dump($i);

        //file_put_contents("ingredientColor.json",json_encode($i));   die();

        return array(
            'entities' => $i,
        );
    }
    /**
     * Creates a new Ingredient entity.
     *
     * @Route("/", name="ingredient_create")
     * @Method("POST")
     * @Template("HCocktailBundle:Ingredient:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ingredient();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ingredient_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Ingredient entity.
    *
    * @param Ingredient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Ingredient $entity)
    {
        $form = $this->createForm(new IngredientType(), $entity, array(
            'action' => $this->generateUrl('ingredient_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ingredient entity.
     *
     * @Route("/new", name="ingredient_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ingredient();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ingredient entity.
     *
     * @Route("/{id}", name="ingredient_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ingredient entity.
     *
     * @Route("/{id}/edit", name="ingredient_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
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
    * Creates a form to edit a Ingredient entity.
    *
    * @param Ingredient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ingredient $entity)
    {
        $form = $this->createForm(new IngredientType(), $entity, array(
            'action' => $this->generateUrl('ingredient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ingredient entity.
     *
     * @Route("/{id}", name="ingredient_update")
     * @Method("PUT")
     * @Template("HCocktailBundle:Ingredient:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HCocktailBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ingredient_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ingredient entity.
     *
     * @Route("/{id}", name="ingredient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HCocktailBundle:Ingredient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ingredient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ingredient'));
    }

    /**
     * Creates a form to delete a Ingredient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingredient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
