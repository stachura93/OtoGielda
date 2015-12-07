<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AuctionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('enabled', 'checkbox', array('required' => false))
                   ->add('title', 'text')
                   ->add('content', 'text')
                   ->add('picturePath', 'text', array('required' => false))
                   ->add('startAuction', 'datetime')
                   ->add('endAuction', 'datetime')
                   ->add('user', 'entity', array(
                        'class' => 'Application\Sonata\UserBundle\Entity\User',
                        'property' => 'username',
                    ))
                   ->add('commentFromBuyer', 'entity', array(
                        'class' => 'AppBundle\Entity\Comment',
                        'property' => 'description',
                        'required' => false,
                    ))
                    ->add('commentFromSeller', 'entity', array(
                        'class' => 'AppBundle\Entity\Comment',
                        'property' => 'description',
                        'required' => false,
                    ))
                   ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
    }

     public function toString($object)
    {
        return $object instanceof Auction
            ? $object->getTitle()
            : 'Auction'; // shown in the breadcrumb on the create view
    }
}