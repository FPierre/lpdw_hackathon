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
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('HCocktailBundle:Ingredient')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Lists all Ingredient entities.
     *
     * @Route("/colors", name="ingredient_colors")
     * @Method("GET")
     * @Template()
     */
    public function colorsAction()
    {
        function getGoogleImage($query) {
            $url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . $query .
                "&userip=194.167.235.232" . "&imgc=color" . "&as_filetype=jpg" . "&imgsz=small|medium" . "&imgtype=photo";

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
     * @Route("/balanceColors", name="ingredient_balanceColors")
     * @Method("GET")
     * @Template("HCocktailBundle:Ingredient:colors.html.twig")
     */
    public function balanceColorsAction(Request $request)
    {
        function rgbToHsl( $r, $g, $b ) {
            $oldR = $r;
            $oldG = $g;
            $oldB = $b;

            $r /= 255;
            $g /= 255;
            $b /= 255;

            $max = max( $r, $g, $b );
            $min = min( $r, $g, $b );

            $h;
            $s;
            $l = ( $max + $min ) / 2;
            $d = $max - $min;

                if( $d == 0 ){
                    $h = $s = 0; // achromatic
                } else {
                    $s = $d / ( 1 - abs( 2 * $l - 1 ) );

                switch( $max ){
                        case $r:
                            $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
                                if ($b > $g) {
                                $h += 360;
                            }
                            break;

                        case $g:
                            $h = 60 * ( ( $b - $r ) / $d + 2 );
                            break;

                        case $b:
                            $h = 60 * ( ( $r - $g ) / $d + 4 );
                            break;
                    }
            }

            return array( round( $h, 2 ), round( $s, 2 ), round( $l, 2 ) );
        }

        $oldColors = '{"Calvados":"#a59e9d","Jus de citron":"#8e6e48","Grenadine":"#cbaaa4","Liqueur de\nframboise":"#c6aba1","Cointreau":"#d5c8c1","Armagnac":"#d4ac8d","Liqueur de\nprunelle":"#f1f0e9","Jus de fruits\nde la passion":"#f5e2d3","Liqueur\nd\u2019amande\ndouce":"#d4d3ce","Cura\u00e7ao bleu":"#dbe3eb","Jus d\u2019orange":"#fcdbaf","B\u00e9n\u00e9dictine":"#9d8984","Chartreuse":"#fff","Angostura":"#bbb8a8","Liqueur de\nmandarine":"#ecdcd6","Cognac":"#b6a29f","Jus de\npamplemousse":"#f9d0be","Izarra jaune":"#faf5da","Nectar de\nraisin muscat":"#bbcbc4","Sirop de\ngrenadine":"#eae1db","Cr\u00e8me de cassis":"#bfb2a5","Liqueur de\np\u00eache":"#dfcebe","Champagne":"#2d1e12","Guignolet":"#ddd6d0","Pulpe de\np\u00eache fraiche":"#8c6449","Grand Marnier":"#a09390","Liqueur de\ncerise":"#fff","Guiness":"#615d57","Noilly Prat":"#c4c8b6","Cr\u00e8me\nd\u2019abricot":"#f8eddd","Cr\u00e8me de\nframboise":"#fff","Vermouth\nblanc":"#eceae4","Jaune d\u2019\u0153uf":"#efd6b7","Miel":"#cc941e","Sucre imbib\u00e9\nd\u2019angostura et \u00e9cras\u00e9":"#fff","Zeste de citron":"#fff","Cr\u00e8me de coco":"#d8ccbd","Liqueur de\nbanane":"#efe8d6","Gin":"#b5b2b3","Zeste de\ncitron vert":"#f0eed6","Liqueur de\nfraise":"#f3eceb","Vermouth\nrouge":"#caafa2","Vermouth\nblanc sec":"#ada69e","Alcool de poire":"#626649","Zeste d\u2019orange":"#fbe0a7","Liqueur de\npoire":"#ebeade","Liqueur\nd\u2019abricot":"#f8eddd","Nectar de\ngoyave":"#f6eee7","Cr\u00e8me de\ncacao":"#dddad5","Cr\u00e8me fraiche":"#dbd9d1","Cr\u00e8me d\u2019abricot":"#f8eddd","Martini rouge":"#e0dddc","Campari":"#ede6e4","Eau gazeuse":"#79abd6","Anisette":"#f0efe8","Liqueur de\ncaf\u00e9":"#e5e2e1","Liqueur de\ncacao":"#e7e2e0","Bitter sans\nalcool":"#b49065","Nectar de poire":"#e6dfd0","Peppermint":"#3d7e22","Lait":"#bcc0bd","Picon":"#c6b5a3","Cr\u00e8me de\nmenthe":"#fff","Vodka":"#c8bab7","Tabasco":"#fff","Poivre":"#898a60","Liqueur de\nfraises des bois":"#f3eceb","Drambuie":"#6e5638","X\u00e9r\u00e8s":"#46342e","Sherry":"#fff","Cr\u00e8me de mure":"#777e7b","Schweppes":"#e0d6c0","Cr\u00e8me de\nbanane":"#fff","Cr\u00e8me de\nmandarine":"#9e7256","Tonic":"#f1ede0","Marie Brizard":"#c5b8b7","Ginger ale":"#dfbd99","Liqueur de\nfenouil":"#889f93","Vermouth sec":"#ada69e","Ognon piqu\u00e9\nsur une\nbrochette":"#82705b","Jus de\ncitron vert":"#e3e6d7","Blanc d\u2019\u0153uf":"#fff","Amaretto":"#c7b5ae","Jus de fruits\nm\u00e9lang\u00e9s":"#a0846c","Sucre de canne":"#dccbb7","Cherry-brandy":"#937a7e","Sucre en poudre":"#e7acc0","Poire Williams":"#fff","Whisky":"#c1b8ad","Rhum brun":"#d8c6ba","Kirsch":"#fff","Nectar de\nmyrtille":"#d0cfd1","Geni\u00e8vre":"#c7cab1","Izarra verte":"#9cca9e","Jus de cerise":"#b68c8e","Brochette de\ncerises":"#ba999c","Sirop d\u2019orgeat":"#f3eee3","Parfait Amour":"#fff","Sirop de vanille":"#c3a695","Nectar de\nmandarine":"#fff","Cacao":"#696c32","Th\u00e9 chaud":"#5d5045","Eau de vie\nde poire":"#dfdcc9","Liqueur de poire":"#ebeade","Nectar de\npoire":"#e6dfd0","Mandarine\nimp\u00e9riale":"#e3cabb","Sirop de\ngingembre":"#858076","Rhum blanc":"#f6f4f2","Jus d\u2019ananas":"#e2d9aa","Cr\u00e8me de\ncacao blanc":"#eae8db","Menthe blanche":"#899e67","Rhum":"#d7cab0","Sirop de\nmandarine":"#c5bda9","Rhum Bacardi":"#e2d2c0","Eau chaude":"#fff","Cocktail de\nfruits exotiques":"#d6ac5f","Jus de citron\nvert":"#e3e6d7","Caf\u00e9 chaud":"#837c76","Citron press\u00e9":"#e8e1c3","T\u00e9quila":"#c8bbb0","Sorbet coco":"#665c53","Lait bouillant":"#292c29","Clous de girofle":"#c5bcb5","Sirop de sucre":"#61615a","Jus de goyave":"#f2d3d3","Nectar de fruits\nde la passion":"#b3a598","Nectar de\np\u00eache":"#f5ebdb","Sirop de\ncannelle":"#e9e8e5","Pulpe de fraise":"#ebe3e2","Sirop de\nframboise":"#e9e1e0","Cr\u00e8me de caf\u00e9":"#a69a84","Rondelle\nd\u2019orange":"#f3e0aa","Rondelle\nde citron":"#e2d68c","Jus de pomme":"#f8d8b7","Saumur\np\u00e9tillant":"#d0cdc7","Vin de noix":"#dfdfdb","Vin blanc\np\u00e9tillant":"#555a4b","Vin rouge\nchaud":"#85715b","Porto":"#565161","Vin blanc sec":"#ebede2","Fruits de\nsaison":"#9f754c","Vin rouge":"#e8e2e3","Zestes de\ncitron et\nd\u2019orange":"#bfb194","Bouquet\nde menthe":"#c8d8b8","Sirop d\u2019ananas":"#edeae4","Liqueur de caf\u00e9":"#e5e2e1","Jus de tomate":"#e5b1ae","Sauce anglaise":"#9a7765","Sel de c\u00e9leri\n\/poivre":"#b79d9b","Fernet Branca":"#aea483","Jus de papaye":"#fff","Bourbon":"#fff","Whisky\ncanadien":"#958781","Cr\u00e8me de cacao":"#dddad5","Scotch whisky":"#c0892e","Southern\nComfort":"#cec0b4","Jus de mangue":"#a5863e","\u0153uf entier":"#e4c3b9","Coca-Cola":"#fb1414","Jus de cassis":"#c9d9c3","Jus de groseille":"#d3ceca","Nectar de\ncerise":"#e6dadd","Jus de\nraisin blanc":"#9e785c","Jus de\nmandarine":"#f3d5ab","Sirop de\nmenthe verte":"#c9d0c7","Caf\u00e9":"#cec9c6","Chantilly":"#313539","Gel\u00e9e de\ngroseille":"#946d73","Sirop de mure":"#fff","Th\u00e9":"#fff","Th\u00e9 glac\u00e9":"#dcc8b2","Sucre":"#4a5052","Framboises":"#822f16","Fraises":"#fff","Th\u00e9 froid":"#e3a96b","Jus de poire":"#f1e7d6","Jus de banane":"#b1765f","Cidre doux":"#c2c0ac","Jus de quetsche":"#d8cfd4","Cidre brut":"#bebda9","Sirop de\nbanane":"#fff","Sirop de citron":"#867741","Sirop de caf\u00e9":"#fff","Glace \u00e0 la\nvanille":"#ddd2bc","Sirop de\nmenthe":"#e1e9dc","Sirop de\nr\u00e9glisse":"#c5bda9","Sorbet au\ncitron vert":"#dadaa1","Glace \u00e0 la\nfraise":"#bd8382","Ricql\u00e8s":"#aab2c7","Sorbet \u00e0\nl\u2019ananas":"#cccdb6","Ananas\np\u00e9tillant":"#fff","Sorbet au\ncassis":"#bf717a","Lait d\u2019amande":"#b4b5b5","Pulpe d\u2019abricot":"#684f45","Jus de p\u00eache":"#fbf1e4","Nectar d\u2019abricot":"#f6dec1","Sirop de cassis":"#e9e5e4","Sirop de fraise":"#e3dbd8","Jus de raisin":"#c5afb7","Jus de\nraisin rouge":"#85564b","Jus de melon":"#f8dfbc","Jus de\nframboise":"#fff","Jus de pomme\np\u00e9tillant":"#f9f0e0","Sirop de\nmyrtille":"#fff","Limonade":"#9a9068","Sirop de\nvanille":"#c3a695","Jus de\nmangue":"#a5863e","Jus de\nmyrtille":"#fff","Nectar de\ncitron vert":"#e9ebda","Nectar de\nmangue":"#e3dbc3","Sirop de\ncerise":"#ece5e4","Jus de\npruneaux":"#e4dfd8","Nectar de\nbanane":"#e6cb9a","Pulpe de kiwi":"#e9e7e4","Jus de\nraisin muscat":"#e3dbc2","Sirop d\u2019orange":"#fff","Mandarines\nbroy\u00e9es au mixer":"#c4b7a8","Cacao en poudre":"#ba6676","Sirop de\npomme":"#dccab9","Sirop de fruits\nde la passion":"#c5bda9","Coulis de\nframboise":"#928785","Sirop de\nmenthe blanc":"#e3ece0","Sirop de\nchocolat":"#e1e0df","Tranches d\u2019oran-\nge piqu\u00e9es de\nclous de girofle":"#84592d","Cerises noires":"#fff","Quartiers\nd\u2019ananas":"#e9c38f","Cannelle":"#cfb8a8","Eau de fleur\nd\u2019oranger":"#f5f3ee","Jus de p\u00eache\nde vigne":"#efe4e4","Jus de raisin\nrouge":"#85564b","Jus de raisin\nblanc":"#9e785c","Radis pass\u00e9s\nau mixer":"#5e655d","Tomates pass\u00e9es\nau mixer":"#58423b","Sel de c\u00e9leri":"#7a7065","Pinc\u00e9e de\nfeuilles de men-\nthe \u00e9minc\u00e9es":"#6b585c","Jus de\nconcombre":"#b9b780","Jus de carotte":"#fff","Pointe de\npiment":"#868b87","Jeune carotte":"#b69c87","Feuilles\nd\u2019\u00e9pinards":"#75884d","Brins de persil":"#5f6e54","Brins de cresson":"#89755e","C\u00f4te de c\u00e9leri":"#d5d386","Betterave\nrouge cuite":"#735b42","Feuilles\nde laitue":"#a8b17f","Tomate":"#e3a68e","Jus de fenouil":"#c4d0b0","Carottes":"#90641d","Pomme":"#fff","Orange":"#f9cd8e","Feuilles\nde menthe":"#5e8c19","Goutte de\ntabasco":"#fff","Tours de moulin\n\u00e0 poivre":"#6b5854","Sirop de melon":"#fff","Vanille":"#d5c6c2","Blancs d\u2019\u0153uf":"#fff","Banane broy\u00e9e\nau mixer":"#fff","Fraises\n\u00e9cras\u00e9es":"#ac7f77","Gla\u00e7ons\nde lait":"#fff","Extrait de\nvanille":"#ad8c76","Sirop de menthe":"#e1e9dc","Sirop de menthe\nblanche":"#fff","Sauce chocolat":"#bca7a9","Lait chaud":"#ece3d3","Eau de rose":"#fff","Sirop d\u2019anis":"#f1ede4","Sirop de vanil-\nle coco":"#c5bda9","Sirop d\u2019\u00e9rable":"#f7dfc0","Sorbet\nde mure":"#9d6d6d"}';
        $colors = json_decode($oldColors);

        $hsl = array();
        foreach ($colors as $name => $hex) {

            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            $h = rgbToHsl($r, $g, $b);



            $hsl[$name] = "hsl(" . $h[0] . "," . 50 . "%," . $h[2]*100 . "%)";
        }

        file_put_contents("ingredientColor.json",json_encode($i));

        return array(
            'entities' => $hsl
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
