<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BiddingAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('winning', 'checkbox', array('required' => false))
                   ->add('amount', 'integer')
                   ->add('biddingDate', 'datetime')
                   ->add('payment', 'entity', array(
                        'class' => 'AppBundle\Entity\Payment',
                        'property' => 'description',
                        'required' => false,
                    ))
                    ->add('shipping', 'entity', array(
                        'class' => 'AppBundle\Entity\Shipping',
                        'property' => 'title',
                        'required' => false,
                    ))
                    ->add('auction', 'entity', array(
                        'class' => 'AppBundle\Entity\Auction',
                        'property' => 'title',
                    ))
                    ->add('user', 'entity', array(
                        'class' => 'Application\Sonata\UserBundle\Entity\User',
                        'property' => 'username',
                    ));
                    ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('amount');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('amount');
    }

     public function toString($object)
    {
        return $object instanceof Bidding
            ? $object->getTitle()
            : 'Bidding'; // shown in the breadcrumb on the create view
    }
}