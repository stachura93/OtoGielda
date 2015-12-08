<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Model\UserManagerInterface;


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
      // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array('entities' => $entities));
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{name}", name="parent_category")
     * @Method("GET")
     * @Template()
     */
    public function showAction($name) {
      $em = $this->getDoctrine()->getManager();

      $id = $em->getRepository('AppBundle:Category')->findBy(array('name' => $name ));

      $cat = $em->getRepository('AppBundle:Category')->findBy(array('parent' => $id ));


      return $this->render('default/index.html.twig', array('entities' => $cat,
        ));
    }

}
