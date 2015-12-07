<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="comment", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Comment
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024, nullable=false)
     */
    private $description;


    /**
     * @var boolean
     *
     * @ORM\Column(name="buyer", type="boolean", nullable=true)
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="comment")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="Auction", mappedBy="commentFromBuyer")
     */
    private $auctionBuyer;

    /**
     * @ORM\OneToOne(targetEntity="Auction", mappedBy="commentFromSeller")
     */
    private $auctionSeller;


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
     * Set description
     *
     * @param string $description
     *
     * @return Comment
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
     * Set buyer
     *
     * @param boolean $buyer
     *
     * @return Comment
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * Get buyer
     *
     * @return boolean
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Comment
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set auctionBuyer
     *
     * @param \AppBundle\Entity\Auction $auctionBuyer
     *
     * @return Comment
     */
    public function setAuctionBuyer(\AppBundle\Entity\Auction $auctionBuyer = null)
    {
        $this->auctionBuyer = $auctionBuyer;

        return $this;
    }

    /**
     * Get auctionBuyer
     *
     * @return \AppBundle\Entity\Auction
     */
    public function getAuctionBuyer()
    {
        return $this->auctionBuyer;
    }

    /**
     * Set auctionSeller
     *
     * @param \AppBundle\Entity\Auction $auctionSeller
     *
     * @return Comment
     */
    public function setAuctionSeller(\AppBundle\Entity\Auction $auctionSeller = null)
    {
        $this->auctionSeller = $auctionSeller;

        return $this;
    }

    /**
     * Get auctionSeller
     *
     * @return \AppBundle\Entity\Auction
     */
    public function getAuctionSeller()
    {
        return $this->auctionSeller;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
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
}
