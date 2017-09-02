<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Province.
 *
 * @ORM\Table(name="provinces")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvinceRepository")
 */
class Province
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nameShort", type="string", length=5, nullable=true)
     */
    private $nameShort;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Postcode", mappedBy="province", cascade={"persist"})
     */
    private $postcodes;

    /**
     * Province constructor.
     *
     * @param string $name
     * @param string $nameShort
     */
    public function __construct(string $name, string $nameShort)
    {
        $this->name = $name;
        $this->nameShort = $nameShort;
        $this->postcodes = new ArrayCollection();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Province
     */
    public function setName($name): Province
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set nameShort.
     *
     * @param string $nameShort
     *
     * @return Province
     */
    public function setNameShort($nameShort): Province
    {
        $this->nameShort = $nameShort;

        return $this;
    }

    /**
     * Get nameShort.
     *
     * @return string
     */
    public function getNameShort(): string
    {
        return $this->nameShort;
    }

    /**
     * Add postcode.
     *
     * @param Postcode $postcode
     */
    public function addPostcode(Postcode $postcode): void
    {
        if (!$this->postcodes->contains($postcode)) {
            $this->postcodes->add($postcode);
            $postcode->setProvince($this);
        }
    }

    /**
     * Remove postcode.
     *
     * @param Postcode $postcode
     */
    public function removePostcode(Postcode $postcode): void
    {
        $this->postcodes->removeElement($postcode);
    }

    /**
     * Get postcodes.
     *
     * @return Collection
     */
    public function getPostcodes(): Collection
    {
        return $this->postcodes;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
