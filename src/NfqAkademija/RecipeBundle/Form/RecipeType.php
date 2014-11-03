<?php

namespace NfqAkademija\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Pavadinimas'))
            ->add('image', null, array('label' => 'Foto'))
            ->add('instructions', null, array('label' => 'Instrukcija'))
            ->add('save', 'submit', array('label' => 'Sukurti'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NfqAkademija\RecipeBundle\Entity\Recipe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nfqakademija_recipebundle_recipe';
    }
}
