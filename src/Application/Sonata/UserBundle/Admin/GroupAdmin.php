<?php
namespace Application\Sonata\UserBundle\Admin;


use Sonata\UserBundle\Admin\Model\GroupAdmin as BaseGroupAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Route\RouteCollection;



class GroupAdmin extends BaseGroupAdmin
{

    public function getNewInstance()
    {
        $class = $this->getClass();
        return new $class('', array());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

         $formMapper
             ->add('roles','choice',array('choices'=>$this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles'),'multiple'=>true ));
        }
}