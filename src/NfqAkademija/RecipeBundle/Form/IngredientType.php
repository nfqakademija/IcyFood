<?php

namespace NfqAkademija\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ingredient', 'entity', array(
            'class' => 'RecipeBundle:Ingredient',
            'property' => 'name',
            'label' => 'Ingredientas'
        ));

        $builder->add('recipe', 'hidden', array(
            'data_class' => 'NfqAkademija\RecipeBundle\Entity\Recipe',
            'data' => NULL,
        ));

        $builder->add('quantity', 'text', array(
            'data' => 1
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NfqAkademija\RecipeBundle\Entity\RecipeIngredient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nfqakademija_recipebundle_ingredient';
    }
}
