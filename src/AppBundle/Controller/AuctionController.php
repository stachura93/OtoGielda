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
use AppBundle\Entity\Bidding;


/**
 * Auction controller.
 *
 */
class AuctionController extends Controller
{

     /**
     * Finds all Auction using title.
     *
     * @Route("/auction/buy", name="auction_buy")
     * @Method("POST")
     * @Template()
     */
     public function buyAction(Request $request)
     {
        $auction = $request->request->get('auction');
        $amount = $request->request->get('amount');
        $price = $request->request->get('price');

        $em = $this->getDoctrine()->getManager();
        $auctionOb= $em->getRepository('AppBundle:Auction')->find($auction);

        $buyerOb = $this->get('security.token_storage')->getToken()->getUser();

        if($auctionOb->getProductAmount() == 0) {
            $auctionOb->setEnabled(false);
        }

        $bidding = new Bidding();
        $bidding->setUser($buyerOb);
        $bidding->setAuction($auctionOb);
        $bidding->setAmount($amount);
        $bidding->setPrice($price);
        $bidding->setBiddingDate(new \DateTime('now'));

        if($auctionOb->getBuyNow() == true) {
            $bidding->setWinning(true);
            $auctionOb->setProductAmount($auctionOb->getProductAmount() - $amount);
        }

        $em->persist($bidding);
        $em->flush();
        return $this->redirect($this->generateUrl('auction_you_buy', array(
            'auctionTitle' => $bidding->getAuction()->getTitle(),
            'auctionIsByNow' => $bidding->getAuction()->getBuyNow(),
            'amount' => $bidding->getAmount(),
            'price' => $bidding->getPrice(),
            )));
    }

   /**
     * Blank change Post .
     *
     * @Route("/auction/youBuy", name="auction_you_buy")
     * @Method("GET")
     * @Template()
     */
   public function blankBuyAction() {
       return $this->render('AppBundle:Auction:buy.html.twig');
   }


    /**
     * Finds all Auction using title.
     *
     * @Route("/auction/search/", name="auction_by_title")
     * @Method("GET")
     * @Template()
     */
    public function find_using_titleAction(Request $request)
    {
        $title = $request->query->get('title');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Auction');

        $query = $repository->createQueryBuilder('a')
        ->where('a.enabled LIKE :enabled')
        ->andWhere('a.title LIKE :title')
        ->setParameter('enabled', true)
        ->setParameter('title', '%'.$title.'%')
        ->getQuery();

        $entities = $query->getResult();

        return $this->render('AppBundle:Auction:index.html.twig', array(
            'entities' => $entities,
            ));
    }

    /**
     * Lists all Auction entities.
     *
     * @Route("/profile/auctions/", name="auction")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Auction')->findBy(array('user' => $user ));

        return $this->render('AppBundle:Auction:find_by_user_profile.html.twig', array(
            'entities' => $entities,
            ));
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
        $auction = $em->getRepository('AppBundle:Auction')->find($id);

        $shippings = $auction->getShipping();
        $payments = $auction->getPayment();

        $query = $em->createQuery('
         SELECT u.username, b.biddingDate, b.amount, MAX(b.price) as price
         FROM AppBundle:Bidding b
         JOIN b.auction a
         JOIN b.user u
         WHERE b.auction = :auction
         GROUP BY b.user
         ORDER BY price DESC
         ');
        $query->setParameter('auction', $auction);

        $biddings = $query->getResult();

        $maxPriceInBiddingVsProductPrice = 1;

        foreach ($biddings as $bidd) {
            if($bidd['price'] > $maxPriceInBiddingVsProductPrice)
                $maxPriceInBiddingVsProductPrice = $bidd['price'];
        }
        if($maxPriceInBiddingVsProductPrice < $auction->getProductPrice())
            $maxPriceInBiddingVsProductPrice = $auction->getProductPrice();

        if (!$auction) {
            throw $this->createNotFoundException('Unable to find Auction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        return array(
            'auction'     => $auction,
            'shippings'   => $shippings,
            'payments'    => $payments,
            'biddings'    => $biddings,
            'maxPriceInBiddingVsProductPrice' => $maxPriceInBiddingVsProductPrice,
            'delete_form' => $deleteForm->createView(),
            );
    }

    /**
     * Displays a form to edit an existing Auction entity.
     *
     * @Route("/profile/auctions/{id}/edit", name="auction_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Auction')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Auction entity.');
        }

        if($entity->getUser() != $user)
            return $this->redirect($this->generateUrl('auction'));

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
