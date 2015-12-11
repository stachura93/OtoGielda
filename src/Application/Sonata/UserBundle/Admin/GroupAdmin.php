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

    // public function getNewInstance()
    // {
    //     $class = $this->getClass();
    //     return new $class('', array());
    // }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');
        $rolesChoices = self::flattenRoles($roles);

        $formMapper->add('roles', 'choice', array(
               'choices'  => $rolesChoices,
               'multiple' => true
        ));
    }


   /**
    * Turns the role's array keys into string <ROLES_NAME> * 
    * keys.
    * @todo Move to convenience or make it recursive ? ;-)
    */
    protected static function flattenRoles($rolesHierarchy)
    {
        $flatRoles = array();
        foreach($rolesHierarchy as $roles) {

            if(empty($roles)) {
                continue;
            }

            foreach($roles as $role) {
                if(!isset($flatRoles[$role])) {
                    $flatRoles[$role] = $role;
                }
            }
        }

        return $flatRoles;
    }
}