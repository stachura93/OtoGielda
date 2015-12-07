<?php
namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=128, nullable=false)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=128, nullable=false)
     */
    protected $street;

    /**
     * @var string
     *
     * @ORM\Column(name="home_number", type="string", length=128, nullable=false)
     */
    protected $home_number;

    /**
     * @var string
     *
     * @ORM\Column(name="other_description", type="string", length=65535, nullable=true)
     */
    protected $other_description;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Auction", mappedBy="user")
     */
    protected $auction;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Bidding", mappedBy="user")
     */
    protected $bidding;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="user")
     */
    protected $message;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user")
     */
    protected $comment;

    /**
     * @ORM\PostLoad
     */
    public function init()
    {
        $this->comment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->auction = new \Doctrine\Common\Collections\ArrayCollection();
        parent::init();
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comment[] = $comment;

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

    /**
     * Add auction
     *
     * @param \AppBundle\Entity\Auction $auction
     *
     * @return User
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
        $this->comment->removeElement($auction);
    }

    // *
    //  * Get auction
    //  *
    //  * @return \Doctrine\Common\Collections\Collection
     
    // public function getAuction()
    // {
    //     return $this->auction;
    // }



    /**
    * Get city
    * @return string
    */
    public function getCity()
    {
        return $this->city;
    }

    /**
    * Set city
    * @return User
    */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
    * Get street
    * @return string
    */
    public function getStreet()
    {
        return $this->street;
    }

    /**
    * Set street
    * @return User
    */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }
    /**
    * Get home_number
    * @return integer
    */
    public function getHomenumber()
    {
        return $this->home_number;
    }

    /**
    * Set home_number
    * @return User
    */
    public function setHomenumber($home_number)
    {
        $this->home_number = $home_number;
        return $this;
    }

    /**
    * Get other_description
    * @return string
    */
    public function getOtherdescription()
    {
        return $this->other_description;
    }

    /**
    * Set other_description
    * @return User
    */
    public function setOtherdescription($other_description)
    {
        $this->other_description = $other_description;
        return $this;
    }

    /**
    * Get auction
    * @return Auction
    */
    public function getAuction()
    {
        return $this->auction;
    }

    /**
    * Set auction
    * @return User
    */
    public function setAuction($auction)
    {
        $this->auction = $auction;
        return $this;
    }
    /**
    * Get bidding
    * @return Bidding
    */
    public function getBidding()
    {
        return $this->bidding;
    }

    /**
    * Set bidding
    * @return User
    */
    public function setBidding($bidding)
    {
        $this->bidding = $bidding;
        return $this;
    }
    /**
    * Get message
    * @return Message
    */
    public function getMessage()
    {
        return $this->message;
    }

    /**
    * Set message
    * @return User
    */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}
