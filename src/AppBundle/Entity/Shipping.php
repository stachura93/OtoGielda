<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shipping
 *
 * @ORM\Table(name="shipping", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Shipping
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="waiting_time_to_send_days", type="integer", nullable=true)
     */
    private $waitingTimeToSendDays;

    /**
     * @var integer
     *
     * @ORM\Column(name="approximate_waiting_time_days", type="integer", nullable=true)
     */
    private $approximateWaitingTimeDays;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Auction", inversedBy="shipping")
     * @ORM\JoinTable(name="auction_auction_shipping")
     */
    private $auction;

    /**
     * @ORM\OneToOne(targetEntity="Bidding", mappedBy="shipping")
     */
    private $bidding;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->auction = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Shipping
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Shipping
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set waitingTimeToSendDays
     *
     * @param integer $waitingTimeToSendDays
     *
     * @return Shipping
     */
    public function setWaitingTimeToSendDays($waitingTimeToSendDays)
    {
        $this->waitingTimeToSendDays = $waitingTimeToSendDays;

        return $this;
    }

    /**
     * Get waitingTimeToSendDays
     *
     * @return integer
     */
    public function getWaitingTimeToSendDays()
    {
        return $this->waitingTimeToSendDays;
    }

    /**
     * Set approximateWaitingTimeDays
     *
     * @param integer $approximateWaitingTimeDays
     *
     * @return Shipping
     */
    public function setApproximateWaitingTimeDays($approximateWaitingTimeDays)
    {
        $this->approximateWaitingTimeDays = $approximateWaitingTimeDays;

        return $this;
    }

    /**
     * Get approximateWaitingTimeDays
     *
     * @return integer
     */
    public function getApproximateWaitingTimeDays()
    {
        return $this->approximateWaitingTimeDays;
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
     * Add auction
     *
     * @param \AppBundle\Entity\Auction $auction
     *
     * @return Shipping
     */
    public function addAuction(\AppBundle\Entity\Auction $auction)
    {
        $this->auction[] = $auction;

        return $this;
    }

    /**
     * Remove auction
     *
     * @param \AppBundle\Entity\Auction $auction
     */
    public function removeAuction(\AppBundle\Entity\Auction $auction)
    {
        $this->auction->removeElement($auction);
    }

    /**
     * Get auction
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuction()
    {
        return $this->auction;
    }

    /**
     * Set bidding
     *
     * @param \AppBundle\Entity\Bidding $bidding
     *
     * @return Shipping
     */
    public function setBidding(\AppBundle\Entity\Bidding $bidding = null)
    {
        $this->bidding = $bidding;

        return $this;
    }

    /**
     * Get bidding
     *
     * @return \AppBundle\Entity\Bidding
     */
    public function getBidding()
    {
        return $this->bidding;
    }
}
