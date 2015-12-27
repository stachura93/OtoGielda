<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;

use AppBundle\Entity\Auction;
use ApplicationSonataUserBundle\EntityUser;

/**
 * Comment controller.
 *
 */
class CommentController extends Controller
{


    /**
     * Lists all auction when user can add new comment.
     *
     * @Route("/profile/comment/addSeller/", name="comment_add_seller")
     * @Method("GET")
     * @Template()
     */
    public function fidAllAddSellerCommentAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $biddingUserWinning = $em->getRepository('AppBundle:Bidding')->findBy(array('user'=> $user, 'winning' => true));

     //   $comments = $em->getRepository('AppBundle:Comment')->findBy(array('userBuyer'=> $user, 'auction' => $biddingUserWinning));


        // $comment = $biddingUserWinning;

  //      $comments = $em->getRepository('AppBundle:Comment')->findBy(array('userBuyer'=> $user, 'auction' => $biddingUserWinning->getAuction()));

        // if($commentsUserBuyer) {
        //    return null;
        // }
        foreach ($biddingUserWinning as $bidding) {
        echo "<pre>";
        echo  print_r($bidding->getAuction());
        echo "</pre>";
        }


        return $this->render('AppBundle:Comment:add_new_comment_to_seller.html.twig', array(
                'comments' => $comments,
        ));
    }

    /**
     * Lists all Comment entities.
     *
     * @Route("/profile/comment/", name="comment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $commentsUserSend = $em->getRepository('AppBundle:Comment')->findBy(array('userSendComment'=> $user));
        $commentsUserReceive = $em->getRepository('AppBundle:Comment')->findBy(array('userReceivedComment'=> $user));

        // $newComment = $em->getRepository('AppBundle:Bidding')->findBy(array('user' => $user, 'winning' ));
        return array(
            'commentsUserSend' => $commentsUserSend,
            'commentsUserReceive' => $commentsUserReceive,
        );
    }

    /**
     * Creates a new Comment entity.
     *
     * @Route("/comment/", name="comment_create")
     * @Method("POST")
     * @Template("AppBundle:Comment:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $entity = new Comment();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to create a new Comment entity.
     *
     * @Route("/saveComment/", name="comment_new")
     * @Method("POST")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $commentForUserRequest = $request->request->get('commentForUser');
        $auctionRequest = $request->request->getInt('auction');
        $descriptionRequest = $request->request->get('description');

        $em = $this->getDoctrine()->getManager();

        $auction = $em->getRepository('AppBundle:Auction')->find($auctionRequest);
        $commentForUser = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('username' => $commentForUserRequest ));

        $entity = new Comment();
        $entity->setDescription($descriptionRequest);
        $entity->setAuction($auction);
        $auction->addComment($entity);


        $user = $this->get('security.token_storage')->getToken()->getUser();

        $entity->setUserSendComment($user);
        $entity->setUserReceivedComment($commentForUser);

        $seller = $auction->getUser();
        if($user == $seller ) {
            echo "Sprzedawca";
            $entity->setBuyer(false);
        } else {
            echo "Kupujacy";
            $entity->setBuyer(true);
        }

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comment_show', array('id' => $entity->getId())));

    }

    /**
     * Finds and displays a Comment entity.
     *
     * @Route("/comment/{id}", name="comment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     * @Route("/comment/{id}/edit", name="comment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
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
    * Creates a form to edit a Comment entity.
    *
    * @param Comment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comment $entity)
    {
        $form = $this->createForm(new CommentType(), $entity, array(
            'action' => $this->generateUrl('comment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Comment entity.
     *
     * @Route("/comment/{id}", name="comment_update")
     * @Method("PUT")
     * @Template("AppBundle:Comment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Comment entity.
     *
     * @Route("/comment/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Comment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('comment'));
    }

    /**
     * Creates a form to delete a Comment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
