<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\ShippingType;

class AuctionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled')
            ->add('title')
            ->add('content')
            ->add('picturePath')
            ->add('startAuction')
            ->add('endAuction')
            ->add('product_amount')
            ->add('product_price')
            ->add('user')
            ->add('Category', 'entity', array(
                        'class' => 'AppBundle\Entity\Category',
                        'property' => 'name',
            ))
            ->add('Shipping', 'collection', array(
                  'type' => new ShippingType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  //'prototype' => true
                ))
            // ->add('Shipping', 'entity', array(
            //             'class' => 'AppBundle\Entity\Shipping',
            //             'property' => 'title',
            //             'multiple' => true,
            //             'expanded' => true,
            // ))
            // ->add('Shipping', 'collection', array(
            //     'type' => new ShippingType(),

            //       'allow_add' => true,
            //         'prototype' => true,
            //         // Post update
            //         'by_reference' => false,
            // ))
            // ->add('Payment', 'entity', array(
            //             'class' => 'AppBundle\Entity\Payment',
            //             'property' => 'methodName',
            //             'multiple' => true,
            //             'expanded' => true,
            // ));

            // ;
            ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Auction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_auction';
    }
}
