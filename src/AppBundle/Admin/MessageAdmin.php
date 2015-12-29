<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MessageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('content', 'text')
        ->add('postDate', 'datetime')
        ->add('Auction', 'entity', array(
            'class' => 'AppBundle\Entity\Auction',
            'property' => 'title',
            ))
        ->add('userRecipient', 'entity', array(
            'class' => 'Application\Sonata\UserBundle\Entity\User',
            'property' => 'username',
            ))
        ->add('userSender', 'entity', array(
            'class' => 'Application\Sonata\UserBundle\Entity\User',
            'property' => 'username',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('content');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('content');
    }

    public function toString($object)
    {
        return $object instanceof Message
        ? $object->getTitle()
            : 'Message'; // shown in the breadcrumb on the create view
    }
}