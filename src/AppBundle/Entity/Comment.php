<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="USER_COMMENT")
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
     * @ORM\JoinColumn(name="user_received_comment_id", referencedColumnName="id")
     */
    private $userReceivedComment;

     /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="comment")
     * @ORM\JoinColumn(name="user_send_comment_id", referencedColumnName="id")
     */
     private $userSendComment;

    /**
     *  @ORM\ManyToOne(targetEntity="Auction", inversedBy="comment")
     *  @ORM\JoinColumn(name="auction_id", referencedColumnName="id")
     */
    private $auction;



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

    /**
     * Set auction
     *
     * @param \AppBundle\Entity\Auction $auction
     *
     * @return Comment
     */
    public function setAuction(\AppBundle\Entity\Auction $auction = null)
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


    /**
     * Set userReceivedComment
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userReceivedComment
     *
     * @return Comment
     */
    public function setUserReceivedComment(\Application\Sonata\UserBundle\Entity\User $userReceivedComment = null)
    {
        $this->userReceivedComment = $userReceivedComment;

        return $this;
    }

    /**
     * Get userReceivedComment
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserReceivedComment()
    {
        return $this->userReceivedComment;
    }

    /**
     * Set userSendComment
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userSendComment
     *
     * @return Comment
     */
    public function setUserSendComment(\Application\Sonata\UserBundle\Entity\User $userSendComment = null)
    {
        $this->userSendComment = $userSendComment;

        return $this;
    }

    /**
     * Get userSendComment
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserSendComment()
    {
        return $this->userSendComment;
    }
}
