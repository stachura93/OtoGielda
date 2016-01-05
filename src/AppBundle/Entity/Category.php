<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 *
 */
class Category
{
    /**
     * @var string
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\Column(name="name", type="string", length=20, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;

     /**
     * @ORM\OneToMany(targetEntity="Auction", mappedBy="category")
     */
     private $auction;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="name")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", nullable=true)
     */
    private $parent;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->auction = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return Category
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
     * Set parent
     *
     * @param \AppBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\AppBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }
}
