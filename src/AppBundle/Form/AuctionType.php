<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('product')
            ->add('user')
            ->add('commentFromBuyer')
            ->add('commentFromSeller')
            ->add('payment')
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
