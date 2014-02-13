<?php

namespace H\CocktailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StatType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', 'entity', array(
                'class'    => 'HCocktailBundle:Color',
                'property' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label'    => 'Couleur',
                'attr' => array('class' => 'form-control selectpicker')
            ))
            ->add('age', 'entity', array(
                'class'    => 'HCocktailBundle:Age',
                'property' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label'    => 'Âge',
                'attr' => array('class' => 'form-control selectpicker')
            )) 
            ->add('langage', 'entity', array(
                'class'    => 'HCocktailBundle:Langage',
                'property' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label'    => 'Langage',
                'attr' => array('class' => 'form-control selectpicker')
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'H\CocktailBundle\Entity\Stat'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'h_cocktailbundle_stat';
    }
}
