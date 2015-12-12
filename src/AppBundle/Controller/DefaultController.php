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
      // // replace this example code with whatever you need
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

      // // replace this example code with whatever you need
         return array(
            'entity' => $entity,
        );
    }

     /**
     * Return user by ID
     *
     * @Route("/newAuction/", name="new_auction")
     * @Method("GET")
     * @Template()
     */
    public function create_auctionAction(Request $request)
    {
    $auction = new Auction();
    $shipping1 = new Shipping();

    $auction->addShipping($shipping1);

    $form = $this->createForm(new AuctionType(), $auction);

    $form->handleRequest($request);

    if ($form->isValid()) {

        $em = $this->getDoctrine()->getManager();
        $em->persist($auction);
        $em->flush();

    }
        return array(
            'form' => $form->createView(),
        );
    }


}
