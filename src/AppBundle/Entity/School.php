<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="schools")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolRepository")
 */
class School
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Talent", mappedBy="school", cascade={"all"})
     */
    private $talents;

    /**
     * Camp constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->talents = new ArrayCollection();
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
     * @return School
     */
    public function setName(string $name): School
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
     * @return School
     */
    public function setAddress(string $address = null): School
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
     * @return School
     */
    public function setAddress2(string $address2 = null): School
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
     * @return School
     */
    public function setPostcode(Postcode $postcode = null): School
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
     * Add talent.
     *
     * @param Talent $talent
     */
    public function addTalent(Talent $talent): void
    {
        if (!$this->talents->contains($talent)) {
            $this->talents->add($talent);
        }
    }

    /**
     * Remove talent.
     *
     * @param Talent $talent
     */
    public function removeTalent(Talent $talent): void
    {
        $this->talents->removeElement($talent);
    }

    /**
     * Get talents.
     *
     * @return Collection
     */
    public function getTalents(): Collection
    {
        return $this->talents;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
