<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Auction", inversedBy="message")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id")
     */
    private $auction;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="message")
     * @ORM\JoinColumn(name="user_sender_id", referencedColumnName="id")
     */
    private $userSender;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="message")
     * @ORM\JoinColumn(name="user_recipient_id", referencedColumnName="id")
     */
    private $userRecipient;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime", nullable=false)
     */
    private $postDate;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct()
    {
        $this->postDate = new \DateTime();
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
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
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Message
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
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
     * Set auction
     *
     * @param \AppBundle\Entity\Auction $auction
     *
     * @return Message
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
     * Set userSender
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userSender
     *
     * @return Message
     */
    public function setUserSender(\Application\Sonata\UserBundle\Entity\User $userSender = null)
    {
        $this->userSender = $userSender;

        return $this;
    }

    /**
     * Get userSender
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserSender()
    {
        return $this->userSender;
    }

    /**
     * Set userRecipient
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userRecipient
     *
     * @return Message
     */
    public function setUserRecipient(\Application\Sonata\UserBundle\Entity\User $userRecipient = null)
    {
        $this->userRecipient = $userRecipient;

        return $this;
    }

    /**
     * Get userRecipient
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserRecipient()
    {
        return $this->userRecipient;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
