<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Message;
use AppBundle\Form\MessageType;

/**
 * Message controller.
 *
 */
class MessageController extends Controller
{
    /**
     * Finds and displays a Message entity.
     *
     * @Route("/profile/messages/sender/{subject}-{userMessage}", name="message_show_all_sender")
     * @Route("/profile/messages/recipient/{subject}-{userMessage}", name="message_show_all_recipient")
     * @Method("GET")
     * @Template()
     */
    public function showAllMessageAction($subject, $userMessage)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $userMessage = $em->getRepository('ApplicationSonataUserBundle:User')->findBy(array('username' => $userMessage ));

        $messagesUserSender = $em->getRepository('AppBundle:Message')->findBy(array('subject' => $subject, 'userSender' => $user,  'userRecipient' => $userMessage));
        $messagesUserRecipient = $em->getRepository('AppBundle:Message')->findBy(array('subject' => $subject, 'userRecipient' => $user, 'userSender' => $userMessage));

        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        if($routeName == 'message_show_all_sender')
        {
            return $this->render('AppBundle:Message:show_sender_message_auction.html.twig', array(
                 'messagesUserSender' => $messagesUserSender,
                 'messagesUserRecipient' => $messagesUserRecipient,
            ));
        };
        return $this->render('AppBundle:Message:show_recipient_message_auction.html.twig', array(
            'messagesUserSender' => $messagesUserSender,
            'messagesUserRecipient' => $messagesUserRecipient,
            ));
    }


     /**
     * Finds user message by ID.
     *
     * @Route("/profile/messages/sender/", name="messages_sender")
     * @Route("/profile/messages/recipient/", name="messages_recipient")
     * @Method("GET")
     * @Template()
     */
     public function find_by_userAction()
     {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        if($routeName == 'messages_sender')
        {
            $messagesUserSender = $em->getRepository('AppBundle:Message')->createQueryBuilder('m')
            ->where('m.userSender = :user')->setParameter('user', $user)->orderBy('m.postDate', 'DESC')->getQuery();
            $messagesUserSender = $messagesUserSender->getResult();

            return $this->render('AppBundle:Message:show_sender_message_by_user.html.twig', array(
                'entities' => $messagesUserSender,
                ));
        };

        $messagesUserRecipient = $em->getRepository('AppBundle:Message')->createQueryBuilder('m')
        ->where('m.userRecipient = :user')->setParameter('user', $user)->orderBy('m.postDate', 'DESC')->getQuery();
        $messagesUserRecipient = $messagesUserRecipient->getResult();

        return $this->render('AppBundle:Message:show_recipient_message_by_user.html.twig', array(
            'entities' => $messagesUserRecipient,
            ));
    }


    /**
     * Creates a new Message entity.
     *
     * @Route("/message/", name="message_create")
     * @Method("POST")
     * @Template("AppBundle:Message:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Message();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('message_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
    }

    /**
     * Creates a form to create a Message entity.
     *
     * @param Message $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Message $entity)
    {
        $form = $this->createForm(new MessageType(), $entity, array(
            'action' => $this->generateUrl('message_create'),
            'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Message entity.
     *
     * @Route("/message/new/{userRecipient}-{auction}", name="message_new")
     * @Route("/message/new/{userRecipient}-{auction}/{subject}", name="message_new_subject")
     * @Method("GET")
     * @Template()
     */
    public function newAction($userRecipient, $auction, $subject=null)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $entity = new Message();

        $entity->setSubject($subject);
        $entity->setUserSender($user);

        $em = $this->getDoctrine()->getManager();
        $userRecipient = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('username' => $userRecipient ));
        $auction = $em->getRepository('AppBundle:Auction')->findOneBy(array('id' => $auction));

        $entity->setUserRecipient($userRecipient);
        $entity->setAuction($auction);
        $auction->addMessage($entity);

        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            );
    }

    /**
     * Finds and displays a Message entity.
     *
     * @Route("/message/{id}", name="message_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Message')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            );
    }

    /**
     * Displays a form to edit an existing Message entity.
     *
     * @Route("/message/{id}/edit", name="message_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Message')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
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
    * Creates a form to edit a Message entity.
    *
    * @param Message $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Message $entity)
    {
        $form = $this->createForm(new MessageType(), $entity, array(
            'action' => $this->generateUrl('message_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Message entity.
     *
     * @Route("/message/{id}", name="message_update")
     * @Method("PUT")
     * @Template("AppBundle:Message:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Message')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('message_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            );
    }
    /**
     * Deletes a Message entity.
     *
     * @Route("/message/{id}", name="message_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Message')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Message entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('message'));
    }

    /**
     * Creates a form to delete a Message entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('message_delete', array('id' => $id)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'Delete'))
        ->getForm()
        ;
    }
}
