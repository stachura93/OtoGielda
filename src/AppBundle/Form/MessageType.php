<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('subject')
        ->add('content')
        ->add('postDate', 'date' ,array('disabled' => true, 'data' => new \DateTime()))
        ->add('userSender')
        ->add('userRecipient')
        ->add('auction', 'entity', array('class' => 'AppBundle:Auction', 'property' => 'id'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Message'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_message';
    }
}
