<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Model\UserManagerInterface;

use AppBundle\Entity\Auction;
use AppBundle\Entity\Shipping;
use AppBundle\Form\AuctionType;

class DefaultController extends Controller
{
  /**
   * @Route("/", name="homepage")
   *
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');

    $query = $repository->createQueryBuilder('c')
    ->where('c.parent IS NULL')
    ->getQuery();

    $entities = $query->getResult();

    return $this->render('default/index.html.twig', array('entities' => $entities));
  }


  /**
   * Return user by ID
   *
   * @Route("/userinformation/{id}", name="userinformation")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('ApplicationSonataUserBundle:User')->find($id);

    return array(
      'entity' => $entity,
      );
  }

    /**
     * @Route("/newAuction", name="newAuction")
     *
     */
    public function createAuctionAction(Request $request)
    {

     if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
       return $this->render('AppBundle:Default:error_page.html.twig');
     }
     $user = $this->get('security.token_storage')->getToken()->getUser();

     $auction = new Auction();
     $auction->setUser($user);
     $auction->setStartAuction(new \DateTime('now'));
     $auction->setEndAuction(new \DateTime('tomorrow'));

     $form = $this->createForm(new AuctionType(), $auction);
     $form->add('submit', 'submit', array('label' => 'Create'));

     if($request->getMethod() === 'POST') {
      $form->bind($request);
      if($form->isValid()) {


        $uploaded_image = $form->get('picturePath')->getData();
        if($uploaded_image) {
          $uploaded_image->move($auction->getAbsolutePath($user->getId()), $uploaded_image->getClientOriginalName());
          $auction->setPicturePath($uploaded_image->getClientOriginalName());
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($auction);
        $em->flush();

        return $this->redirect($this->generateUrl('auction_show',
         array('id' => $auction->getId() )));
      }
    }

    return $this->render('AppBundle:Default:create_auction.html.twig', array(
      'form' => $form->createView(),
      ));
  }


}
