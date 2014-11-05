<?php

namespace NfqAkademija\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredient', new IngredientType())
            ->add('quantity', 'text')
            ->add('unit', 'entity', array(
                'class' => 'RecipeBundle:Unit',
                'property' => 'name',
                'label' => 'Matas'
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
        return 'nfqakademija_recipebundle_recipeingredient';
    }
}
