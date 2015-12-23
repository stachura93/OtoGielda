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
     * Return user comments by ID
     *
     * @Route("/comment/user/{id}", name="user_comment")
     * @Route("/profile/comments/{id}", name="profile_comments")
     * @Method("GET")
     * @Template()
     */
    public function userCommentsAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $entities = $em->getRepository('AppBundle:Comment')->findBy(array('user' => $id ));
      $request = $this->container->get('request');
      $routeName = $request->get('_route');
      if($routeName == 'profile_comments') {
        return $this->render('AppBundle:Comment:user_comments_profile.html.twig', array(
            'entities' => $entities,
        ));
      }

      return $this->render('AppBundle:Comment:user_comments_defaults.html.twig', array(
            'entities' => $entities,
      ));
    }

    /**
     * Lists all Comment entities.
     *
     * @Route("/comment/", name="comment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Comment')->findAll();

        return array(
            'entities' => $entities,
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

        $form = $this->createCreateForm($entity, $request);
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
     * Creates a form to create a Comment entity.
     *
     * @param Comment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Comment $entity, Request $request)
    {
        $commentForUserRequest = $request->request->get('commentForUser');
        // $auctionRequest = $request->request->getInt('auction');


        $em = $this->getDoctrine()->getManager();
      //  $auction = $em->getRepository('AppBundle:Auction')->find($auctionRequest);

        $commentForUser = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('username' => $commentForUserRequest ));


        // echo $auctionID;
       // $auction = $em->getRepository('AppBundle:Auction')->findOneBy(array('id' => $auctionID));
          // $auction->addComment($entity);
          // $entity->setAuction($auction);


        // $seller = $auction->getUser();
        // echo "<pre>";
        // echo print_r($seller);
        // echo "</pre>";
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // $entity->setUserSeller($seller);
        $entity->setUserBuyer($commentForUser);

        // if($user == $seller ) {
        //     echo "Sprzedawca";
        //     $entity->setBuyer(false);
        // } elseif ($user == $commentForUser) {
        //     echo "Kupujacy";
        //     $entity->setBuyer(true);
        // }


        // $auctionRequest = $request->request->get('auction');
        // $commentForUserRequest = $request->request->get('commentForUser');

        $form = $this->createForm(new CommentType());
 // $entity, array(
 //            'action' => $this->generateUrl('comment_create'),
 //            'method' => 'POST',
 //        ));
        // $form->add('auction', 'entity', array(
        //     'class' => 'AppBundle:Auction',
        //     'property'=> 'title',
        //     'query_builder' => function(\Doctrine\ORM\EntityRepository $er) use ($auctionRequest) {
        //                return $er->createQueryBuilder('a')
        //                      ->where('a.id = :id')
        //                      ->setParameter('id', $auctionRequest);
        //             },
        // ));

         $form->handleRequest($request);
        // $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Comment entity.
     *
     * @Route("/saveComment/", name="comment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Comment();

        $form   = $this->createCreateForm($entity, $request);


    

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
echo "sd";
            return $this->redirectToRoute('task_success');
        }

       //     if ($form->isSubmitted() && $form->isValid()) {
       //  // ... perform some action, such as saving the task to the database

       //  return $this->redirectToRoute('task_success');
       // }


        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
