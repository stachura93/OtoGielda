<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ShippingAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', 'text')
        ->add('price', 'integer')
        ->add('waitingTimeToSendDays', 'text')
        ->add('approximateWaitingTimeDays', 'text')
        ->add('Auction', 'entity', array(
            'class' => 'AppBundle\Entity\Auction',
            'property' => 'title',
            'multiple' => 'true',
            'required' => false,
            ));
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
        return $object instanceof Category
        ? $object->getTitle()
            : 'Category'; // shown in the breadcrumb on the create view
    }
}