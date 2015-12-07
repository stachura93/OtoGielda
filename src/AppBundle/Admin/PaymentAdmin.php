<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PaymentAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('method_name', 'text')
                   ->add('description', 'text')
                   ->add('Auction', 'entity', array(
                        'class' => 'AppBundle\Entity\Auction',
                        'property' => 'title',
                        'multiple' => 'true',
                        'required' => false,
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
        return $object instanceof Payment
            ? $object->getTitle()
            : 'Payment'; // shown in the breadcrumb on the create view
    }
}