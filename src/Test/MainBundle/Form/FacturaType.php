<?php

namespace Test\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Test\MainBundle\Entity\Producto;

class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('fecha')
            ->add('productos', 'collection', array(
                'type'           => new ProductoType(),
                'label'          => 'Productos',
                'by_reference'   => false,
                'prototype_data' => new Producto(),
                //'prototype' => new Producto(),
                'allow_delete'   => true,
                'allow_add'      => true,
                'attr'           => array(
                    'class' => 'row productos'
                )
            ))    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\MainBundle\Entity\Factura'
        ));
    }

    public function getName()
    {
        //return 'test_mainbundle_facturatype';
        return 'factura';
    }
}
