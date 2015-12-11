<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bidding
 *
 * @ORM\Table(name="bidding", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Bidding
{
    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Payment", inversedBy="bidding")
     */
    private $payment;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Shipping", inversedBy="bidding")
     */
    private $shipping;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="bidding")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Auction", inversedBy="bidding")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id")
     */
    public $auction;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bidding_date", type="date", nullable=false)
     */
    private $biddingDate;


    /**
     * @var boolean
     *
     * @ORM\Column(name="winning", type="boolean", nullable=true)
     */
    private $winning;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Bidding
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set biddingDate
     *
     * @param \DateTime $biddingDate
     *
     * @return Bidding
     */
    public function setBiddingDate($biddingDate)
    {
        $this->biddingDate = $biddingDate;

        return $this;
    }

    /**
     * Get biddingDate
     *
     * @return \DateTime
     */
    public function getBiddingDate()
    {
        return $this->biddingDate;
    }

    /**
     * Set winning
     *
     * @param boolean $winning
     *
     * @return Bidding
     */
    public function setWinning($winning)
    {
        $this->winning = $winning;

        return $this;
    }

    /**
     * Get winning
     *
     * @return boolean
     */
    public function getWinning()
    {
        return $this->winning;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set paymentId
     *
     * @param \AppBundle\Entity\Payment $paymentId
     *
     * @return Bidding
     */
    public function setPaymentId(\AppBundle\Entity\Payment $paymentId = null)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * Get paymentId
     *
     * @return \AppBundle\Entity\Payment
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Set userId
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userId
     *
     * @return Bidding
     */
    public function setUserId(\Application\Sonata\UserBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set auctionId
     *
     * @param \AppBundle\Entity\Auction $auctionId
     *
     * @return Bidding
     */
    public function setAuctionId(\AppBundle\Entity\Auction $auctionId = null)
    {
        $this->auctionId = $auctionId;

        return $this;
    }

    /**
     * Get auctionId
     *
     * @return \AppBundle\Entity\Auction
     */
    public function getAuctionId()
    {
        return $this->auctionId;
    }

    /**
     * Set shippingId
     *
     * @param \AppBundle\Entity\Shipping $shippingId
     *
     * @return Bidding
     */
    public function setShippingId(\AppBundle\Entity\Shipping $shippingId = null)
    {
        $this->shippingId = $shippingId;

        return $this;
    }

    /**
     * Get shippingId
     *
     * @return \AppBundle\Entity\Shipping
     */
    public function getShippingId()
    {
        return $this->shippingId;
    }

    /**
     * Set payment
     *
     * @param \AppBundle\Entity\Payment $payment
     *
     * @return Bidding
     */
    public function setPayment(\AppBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \AppBundle\Entity\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set shipping
     *
     * @param \AppBundle\Entity\Shipping $shipping
     *
     * @return Bidding
     */
    public function setShipping(\AppBundle\Entity\Shipping $shipping = null)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return \AppBundle\Entity\Shipping
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return Bidding
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set auction
     *
     * @param \AppBundle\Entity\Auction $auction
     *
     * @return Bidding
     */
    public function setAuction(\AppBundle\Entity\Auction $auction)
    {
        $this->auction = $auction;

        return $this;
    }

    /**
     * Get auction
     *
     * @return \AppBundle\Entity\Auction
     */
    public function getAuction()
    {
        return $this->auction;
    }
}
