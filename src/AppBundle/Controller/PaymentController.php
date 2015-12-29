<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Payment;
use AppBundle\Form\PaymentType;

/**
 * Payment controller.
 *
 * @Route("/payment")
 */
class PaymentController extends Controller
{

    /**
     * Lists all Payment entities.
     *
     * @Route("/", name="payment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Payment')->findAll();

        return array(
            'entities' => $entities,
            );
    }
    /**
     * Creates a new Payment entity.
     *
     * @Route("/", name="payment_create")
     * @Method("POST")
     * @Template("AppBundle:Payment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Payment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('payment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
    }

    /**
     * Creates a form to create a Payment entity.
     *
     * @param Payment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Payment $entity)
    {
        $form = $this->createForm(new PaymentType(), $entity, array(
            'action' => $this->generateUrl('payment_create'),
            'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Payment entity.
     *
     * @Route("/new", name="payment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Payment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
    }

    /**
     * Finds and displays a Payment entity.
     *
     * @Route("/{id}", name="payment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Payment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Payment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            );
    }

    /**
     * Displays a form to edit an existing Payment entity.
     *
     * @Route("/{id}/edit", name="payment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Payment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Payment entity.');
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
    * Creates a form to edit a Payment entity.
    *
    * @param Payment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Payment $entity)
    {
        $form = $this->createForm(new PaymentType(), $entity, array(
            'action' => $this->generateUrl('payment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Payment entity.
     *
     * @Route("/{id}", name="payment_update")
     * @Method("PUT")
     * @Template("AppBundle:Payment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Payment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Payment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('payment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            );
    }
    /**
     * Deletes a Payment entity.
     *
     * @Route("/{id}", name="payment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Payment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Payment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('payment'));
    }

    /**
     * Creates a form to delete a Payment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('payment_delete', array('id' => $id)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'Delete'))
        ->getForm()
        ;
    }
}
