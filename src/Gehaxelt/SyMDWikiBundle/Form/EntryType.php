<?php

namespace Gehaxelt\SyMDWikiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('attr' => array('class' => 'form-control')))
            ->add('sortid','text',array('attr' => array('class' => 'form-control')))
            ->add('public','checkbox',array('attr' => array('class' => 'checkbox')))
            ->add('content','textarea',array('attr'=> array('class' => 'form-control', 'rows' => 50)))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gehaxelt\SyMDWikiBundle\Entity\Entry'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gehaxelt_symdwikibundle_entry';
    }
}
