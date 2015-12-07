<?php
namespace Application\Sonata\UserBundle\Admin;


use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Route\RouteCollection;



class UserAdmin extends BaseUserAdmin
{
    /**
        * {@inheritdoc}
        */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('MyData')
                 ->add('city','text', array('label' => 'City'))
                 ->add('street', 'text', array('label' => 'Street'))
                 ->add('home_number', 'integer', array('label' => 'Home number'))
                 ->add('other_description', 'text', array('label' => 'Person desription', 'required' => false))
            ->end()
        ;
    }
}