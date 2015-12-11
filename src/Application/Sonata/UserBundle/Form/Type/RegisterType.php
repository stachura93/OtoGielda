<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder->add('firstname', null, array('required' => true) )
                    ->add('lastName', null, array('required' => true) )
                    ->add('street')
                    ->add('home_number')
                    ->add('city');
    }

    public function getParent()
    {
            return 'fos_user_registration';
    }

    public function getName()
    {
            return 'app_user_registration';
    }
}