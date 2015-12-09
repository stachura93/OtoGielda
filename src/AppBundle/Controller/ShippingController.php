<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Shipping;
use AppBundle\Form\ShippingType;

/**
 * Shipping controller.
 *
 * @Route("/shipping")
 */
class ShippingController extends Controller
{

    /**
     * Lists all Shipping entities.
     *
     * @Route("/", name="shipping")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Shipping')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Shipping entity.
     *
     * @Route("/", name="shipping_create")
     * @Method("POST")
     * @Template("AppBundle:Shipping:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Shipping();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shipping_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Shipping entity.
     *
     * @param Shipping $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Shipping $entity)
    {
        $form = $this->createForm(new ShippingType(), $entity, array(
            'action' => $this->generateUrl('shipping_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Shipping entity.
     *
     * @Route("/new", name="shipping_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Shipping();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Shipping entity.
     *
     * @Route("/{id}", name="shipping_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Shipping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shipping entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Shipping entity.
     *
     * @Route("/{id}/edit", name="shipping_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Shipping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shipping entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Shipping entity.
    *
    * @param Shipping $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Shipping $entity)
    {
        $form = $this->createForm(new ShippingType(), $entity, array(
            'action' => $this->generateUrl('shipping_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Shipping entity.
     *
     * @Route("/{id}", name="shipping_update")
     * @Method("PUT")
     * @Template("AppBundle:Shipping:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Shipping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shipping entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('shipping_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Shipping entity.
     *
     * @Route("/{id}", name="shipping_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Shipping')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Shipping entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('shipping'));
    }

    /**
     * Creates a form to delete a Shipping entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shipping_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
