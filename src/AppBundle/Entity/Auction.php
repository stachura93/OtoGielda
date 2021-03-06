<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Auction
 *
 * @ORM\Table(name="auction")
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
    private $enabled = true;

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
     *  @ORM\OneToMany(targetEntity="Comment", mappedBy="auction",  cascade={"persist", "remove"})
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Payment", mappedBy="auction",  cascade={"persist", "remove"})
     */
    private $payment;

    /**
     * @ORM\ManyToMany(targetEntity="Shipping", mappedBy="auction", cascade={"persist", "remove"})
     */
    private $shipping;

    /**
     * @ORM\OneToMany(targetEntity="Bidding", mappedBy="auction", cascade={"persist", "remove"})
     * @ORM\OrderBy({"price" = "DESC"})
     */
    private $bidding;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="auction", cascade={"persist", "remove"})
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
     * @Assert\Range(min=1, minMessage = "Number of Products should be {{ limit }} or more")
     */
    private $productAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_price", type="decimal", precision=12, scale=2, nullable=false)
     * @Assert\Range(min=1, minMessage = "Product price should be {{ limit }} or more")
     */
    private $productPrice;

    /**
     * @var boolean
     *
     * @ORM\Column(name="new_product", type="boolean", nullable=true)
     */
    private $newProduct = false;

      /**
     * @var boolean
     *
     * @ORM\Column(name="buy_now", type="boolean", nullable=true)
     */
      private $buyNow = false;

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

    public function getAbsolutePath($userId)
    {
        return null === $this->picturePath ? null : $this->getUploadRootDir().'/'.$userId.'/';
    }

    public function getWebPath()
    {
        return null === $this->picturePath ? null : $this->getUploadDir().'/'.$this->picturePath;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../OtoGielda/web'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return '/images';
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
     * Add payment
     *
     * @param \AppBundle\Entity\Payment $payment
     *
     * @return Auction
     */
    public function addPayment(\AppBundle\Entity\Payment $payment)
    {
        $this->payment[] = $payment;
        $payment->addAuction($this);
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
        $shipping->addAuction($this);
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
        $bidding->setAuction($this);
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
        $message->setAuction($this);
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

    /**
     * Set buyNow
     *
     * @param boolean $buyNow
     *
     * @return Auction
     */
    public function setBuyNow($buyNow)
    {
        $this->buyNow = $buyNow;

        return $this;
    }

    /**
     * Get buyNow
     *
     * @return boolean
     */
    public function getBuyNow()
    {
        return $this->buyNow;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Auction
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comment[] = $comment;
        $comment->setAuction($this);
        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment()
    {
        return $this->comment;
    }
}
