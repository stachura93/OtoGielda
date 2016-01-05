<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity
 */
class Payment
{
    /**
     * @var string
     *
     * @ORM\Column(name="method_name", type="string", length=60, nullable=false)
     */
    private $methodName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Auction", inversedBy="payment")
     * @ORM\JoinTable(name="auction_auction_payment")
     */
    private $auction;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Bidding", mappedBy="payment")
     */
    private $bidding;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->auction = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bidding = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->methodName;
    }

    /**
     * Set methodName
     *
     * @param string $methodName
     *
     * @return Payment
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * Get methodName
     *
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Payment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return Payment
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
     * Add bidding
     *
     * @param \AppBundle\Entity\Bidding $bidding
     *
     * @return Payment
     */
    public function addBidding(\AppBundle\Entity\Bidding $bidding)
    {
        $this->bidding[] = $bidding;

        return $this;
    }

    /**
     * Remove bidding
     *
     * @param \AppBundle\Entity\Bidding $bidding
     */
    public function removeBidding(\AppBundle\Entity\Bidding $bidding)
    {
        $this->bidding->removeElement($bidding);
    }

    /**
     * Get bidding
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBidding()
    {
        return $this->bidding;
    }
}
