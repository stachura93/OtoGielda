<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Auction;
use AppBundle\Form\AuctionType;

use AppBundle\Entity\Shipping;

/**
 * Auction controller.
 *
 */
class AuctionController extends Controller
{

    /**
     * Finds all user Auction.
     *
     * @Route("/auction/user/{id}", name="auction_by_user")
     * @Route("/profile/auctions/{id}", name="profile_auctions")
     * @Method("GET")
     * @Template()
     */
    public function find_by_userAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Auction')->findBy(array('user' => $id ));

        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        if($routeName == 'profile_auctions')
        {
            return $this->render('AppBundle:Auction:find_by_user_profile.html.twig', array(
            'entities' => $entities,
        ));
        }
        return $this->render('AppBundle:Auction:find_by_user.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Lists all Auction entities.
     *
     * @Route("/auction/", name="auction")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Auction')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Auction entity.
     *
     * @Route("/auction/", name="auction_create")
     * @Method("POST")
     * @Template("AppBundle:Auction:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Auction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auction_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Auction entity.
     *
     * @param Auction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Auction $entity)
    {

        $form = $this->createForm(new AuctionType(), $entity, array(
            'action' => $this->generateUrl('auction_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Auction entity.
     *
     * @Route("/auction/new", name="auction_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Auction();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Auction entity.
     *
     * @Route("/auction/{id}", name="auction_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Auction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Auction entity.
     *
     * @Route("/auction/{id}/edit", name="auction_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Auction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auction entity.');
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
    * Creates a form to edit a Auction entity.
    *
    * @param Auction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Auction $entity)
    {
        $form = $this->createForm(new AuctionType(), $entity, array(
            'action' => $this->generateUrl('auction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Auction entity.
     *
     * @Route("/auction/{id}", name="auction_update")
     * @Method("PUT")
     * @Template("AppBundle:Auction:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Auction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('auction_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Auction entity.
     *
     * @Route("/auction/{id}", name="auction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Auction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Auction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('auction'));
    }

    /**
     * Creates a form to delete a Auction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('auction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
