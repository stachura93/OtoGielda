<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\AuctionType;

class ShippingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('price')
            ->add('waitingTimeToSendDays')
            ->add('approximateWaitingTimeDays')
            // ->add('Auction', 'entity', array(
            //             'class' => 'AppBundle\Entity\Auction',
            //             'property' => 'title',
            // ));
         

            //       'allow_add' => true,
            //         'prototype' => true,
            //         // Post update
            //         'by_reference' => false,
            // ))        ;
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Shipping'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_shipping';
    }
}
