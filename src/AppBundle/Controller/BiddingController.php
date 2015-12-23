<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Bidding;
use AppBundle\Form\BiddingType;

/**
 * Bidding controller.
 *
 *
 */
class BiddingController extends Controller
{

    /**
     * Return user comments by ID
     *
     * @Route("/profile/auctions/bidding/{auction}", name="bidding_win_in_auction")
     * @Method("GET")
     * @Template()
     */
    public function giveCommentsToAuctionAction($auction)
    {
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:Bidding')->findBy(array('auction' => $auction, 'winning' => true ));

      return $this->render('AppBundle:Bidding:user_win_bidding_in_auction.html.twig', array(
            'entities' => $entities,
      ));
    }
    /**
     * Return lose bidding by User
     *
     * @Route("/profile/bidding_you_lost/{id}", name="profile_you_lose_bidding")
     * @Method("GET")
     * @Template()
     */
    public function loseBiddingByUserAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $entities = $em->getRepository('AppBundle:Bidding')->findBy(array('user' => $id, 'winning' => false ));

        return $this->render('AppBundle:Bidding:by_user.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Return win bidding by User
     *
     * @Route("/profile/bidding_you_win/{id}", name="profile_you_win_bidding")
     * @Method("GET")
     * @Template()
     */
    public function winBiddingByUserAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $entities = $em->getRepository('AppBundle:Bidding')->findBy(array('user' => $id, 'winning' => true ));

        return $this->render('AppBundle:Bidding:by_user.html.twig', array(
            'entities' => $entities,
        ));
    }


     /**
     * Return user by ID
     *
     * @Route("/bidding/auction/{id}", name="bidding_in_auction")
     * @Method("GET")
     * @Template()
     */
    public function in_auctionAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $entities = $em->getRepository('AppBundle:Bidding')->findBy(array('auction' => $id ));

      // // replace this example code with whatever you need
         return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Bidding entities.
     *
     * @Route("/bidding/", name="bidding")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Bidding')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Bidding entity.
     *
     * @Route("/bidding/", name="bidding_create")
     * @Method("POST")
     * @Template("AppBundle:Bidding:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Bidding();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bidding_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Bidding entity.
     *
     * @param Bidding $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Bidding $entity)
    {
        $form = $this->createForm(new BiddingType(), $entity, array(
            'action' => $this->generateUrl('bidding_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Bidding entity.
     *
     * @Route("/bidding/new", name="bidding_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bidding();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Bidding entity.
     *
     * @Route("/bidding/{id}", name="bidding_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Bidding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bidding entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Bidding entity.
     *
     * @Route("/bidding/{id}/edit", name="bidding_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Bidding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bidding entity.');
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
    * Creates a form to edit a Bidding entity.
    *
    * @param Bidding $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bidding $entity)
    {
        $form = $this->createForm(new BiddingType(), $entity, array(
            'action' => $this->generateUrl('bidding_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Bidding entity.
     *
     * @Route("/bidding/{id}", name="bidding_update")
     * @Method("PUT")
     * @Template("AppBundle:Bidding:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Bidding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bidding entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bidding_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Bidding entity.
     *
     * @Route("/bidding/{id}", name="bidding_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Bidding')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bidding entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bidding'));
    }

    /**
     * Creates a form to delete a Bidding entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bidding_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
