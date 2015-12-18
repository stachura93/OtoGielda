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


}
