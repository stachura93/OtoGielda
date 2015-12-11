<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auction
 *
 * @ORM\Table(name="auction", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Auction
{

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="auction")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_path", type="string", length=512, nullable=true)
     */
    private $picturePath;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_auction", type="datetime", nullable=false)
     */
    private $startAuction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_auction", type="datetime", nullable=false)
     */
    private $endAuction;

    /**
     * @ORM\OneToOne(targetEntity="Comment", inversedBy="auctionBuyer")
     */
    private $commentFromBuyer;

    /**
     * @ORM\OneToOne(targetEntity="Comment", inversedBy="auctionSeller")
     */
    private $commentFromSeller;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Payment", mappedBy="auction")
     */
    private $payment;

    /**
     * @ORM\OneToMany(targetEntity="Shipping", mappedBy="auction")
     */
    private $shipping;

    /**
     * @ORM\OneToMany(targetEntity="Bidding", mappedBy="auction")
     */
    private $bidding;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="auction")
     */
    private $message;

     /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="auction")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_amount", type="integer", nullable=false)
     */
    private $productAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_price", type="integer", nullable=false)
     */
    private $productPrice;

    /**
     * @var boolean
     *
     * @ORM\Column(name="new_product", type="boolean", nullable=true)
     */
    private $newProduct = false;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shipping = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bidding = new \Doctrine\Common\Collections\ArrayCollection();
        $this->message = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Auction
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Auction
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
     * Set content
     *
     * @param string $content
     *
     * @return Auction
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Auction
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    /**
     * Get picturePath
     *
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * Set startAuction
     *
     * @param \DateTime $startAuction
     *
     * @return Auction
     */
    public function setStartAuction($startAuction)
    {
        $this->startAuction = $startAuction;

        return $this;
    }

    /**
     * Get startAuction
     *
     * @return \DateTime
     */
    public function getStartAuction()
    {
        return $this->startAuction;
    }

    /**
     * Set endAuction
     *
     * @param \DateTime $endAuction
     *
     * @return Auction
     */
    public function setEndAuction($endAuction)
    {
        $this->endAuction = $endAuction;

        return $this;
    }

    /**
     * Get endAuction
     *
     * @return \DateTime
     */
    public function getEndAuction()
    {
        return $this->endAuction;
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
     * Set productAmount
     *
     * @param integer $productAmount
     *
     * @return Auction
     */
    public function setProductAmount($productAmount)
    {
        $this->productAmount = $productAmount;

        return $this;
    }

    /**
     * Get productAmount
     *
     * @return integer
     */
    public function getProductAmount()
    {
        return $this->productAmount;
    }

    /**
     * Set productPrice
     *
     * @param integer $productPrice
     *
     * @return Auction
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return integer
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * Set newProduct
     *
     * @param boolean $newProduct
     *
     * @return Auction
     */
    public function setNewProduct($newProduct)
    {
        $this->newProduct = $newProduct;

        return $this;
    }

    /**
     * Get newProduct
     *
     * @return boolean
     */
    public function getNewProduct()
    {
        return $this->newProduct;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return Auction
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
     * Set commentFromBuyer
     *
     * @param \AppBundle\Entity\Comment $commentFromBuyer
     *
     * @return Auction
     */
    public function setCommentFromBuyer(\AppBundle\Entity\Comment $commentFromBuyer = null)
    {
        $this->commentFromBuyer = $commentFromBuyer;

        return $this;
    }

    /**
     * Get commentFromBuyer
     *
     * @return \AppBundle\Entity\Comment
     */
    public function getCommentFromBuyer()
    {
        return $this->commentFromBuyer;
    }

    /**
     * Set commentFromSeller
     *
     * @param \AppBundle\Entity\Comment $commentFromSeller
     *
     * @return Auction
     */
    public function setCommentFromSeller(\AppBundle\Entity\Comment $commentFromSeller = null)
    {
        $this->commentFromSeller = $commentFromSeller;

        return $this;
    }

    /**
     * Get commentFromSeller
     *
     * @return \AppBundle\Entity\Comment
     */
    public function getCommentFromSeller()
    {
        return $this->commentFromSeller;
    }

    /**
     * Add payment
     *
     * @param \AppBundle\Entity\Payment $payment
     *
     * @return Auction
     */
    public function addPayment(\AppBundle\Entity\Payment $payment)
    {
        $this->payment[] = $payment;

        return $this;
    }

    /**
     * Remove payment
     *
     * @param \AppBundle\Entity\Payment $payment
     */
    public function removePayment(\AppBundle\Entity\Payment $payment)
    {
        $this->payment->removeElement($payment);
    }

    /**
     * Get payment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Add shipping
     *
     * @param \AppBundle\Entity\Shipping $shipping
     *
     * @return Auction
     */
    public function addShipping(\AppBundle\Entity\Shipping $shipping)
    {
        $this->shipping[] = $shipping;

        return $this;
    }

    /**
     * Remove shipping
     *
     * @param \AppBundle\Entity\Shipping $shipping
     */
    public function removeShipping(\AppBundle\Entity\Shipping $shipping)
    {
        $this->shipping->removeElement($shipping);
    }

    /**
     * Get shipping
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Add bidding
     *
     * @param \AppBundle\Entity\Bidding $bidding
     *
     * @return Auction
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

    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return Auction
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->message[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->message->removeElement($message);
    }

    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Auction
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
