<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CommentAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('description', 'text')
                   ->add('buyer', 'checkbox', array('required' => false))
                   ->add('userSendComment', 'entity', array(
                        'class' => 'Application\Sonata\UserBundle\Entity\User',
                        'property' => 'username',
                    ))->add('userReceivedComment', 'entity', array(
                        'class' => 'Application\Sonata\UserBundle\Entity\User',
                        'property' => 'username',
                    ))->add('auction', 'entity', array(
                        'class' => 'AppBundle\Entity\Auction',
                        'property' => 'title',
                    ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('description');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('description');
    }

     public function toString($object)
    {
        return $object instanceof Comment
            ? $object->getTitle()
            : 'Comment'; // shown in the breadcrumb on the create view
    }
}