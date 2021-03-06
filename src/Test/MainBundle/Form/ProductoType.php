<?php

namespace Test\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('precio')    
            ->add('cantidad')
            ->add('timestampInicio', 'datetime' ,array(
                    'date_widget'=> 'single_text','label' =>'Inicio (d/m/a)',
                    'date_format'=>'d/M/y','time_widget' => 'single_text'))
            //->add('factura')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\MainBundle\Entity\Producto'
        ));
    }

    public function getName()
    {
        //return 'test_mainbundle_productotype';
        return 'producto';
    }
}
