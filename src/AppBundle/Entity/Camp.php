<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Camp
 *
 * @ORM\Table(name="camps")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampRepository")
 */
class Camp
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
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var Postcode
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Postcode", cascade={"persist"})
     * @ORM\JoinColumn(name="postcode_id", nullable=true, fieldName="id")
     */
    private $postcode;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ModulePart", mappedBy="camp", cascade={"all"})
     */
    private $moduleParts;

    /**
     * Camp constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->moduleParts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Camp
     */
    public function setName(string $name): Camp
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Camp
     */
    public function setAddress(string $address = null): Camp
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return Camp
     */
    public function setAddress2(string $address2 = null): Camp
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2.
     *
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * Set postcode.
     *
     * @param Postcode $postcode
     *
     * @return Camp
     */
    public function setPostcode(Postcode $postcode = null): Camp
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode.
     *
     * @return Postcode|null
     */
    public function getPostcode(): ?Postcode
    {
        return $this->postcode;
    }

    /**
     * Add module part.
     *
     * @param ModulePart $modulePart
     */
    public function addModulePart(ModulePart $modulePart): void
    {
        if (!$this->moduleParts->contains($modulePart)) {
            $this->moduleParts->add($modulePart);
        }
    }

    /**
     * Remove module part.
     *
     * @param ModulePart $modulePart
     */
    public function removeModulePart(ModulePart $modulePart): void
    {
        $this->moduleParts->removeElement($modulePart);
    }

    /**
     * Get module parts.
     *
     * @return Collection
     */
    public function getModuleParts(): Collection
    {
        return $this->moduleParts;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
