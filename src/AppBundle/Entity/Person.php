<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table(name="persons")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="familyName", type="string", length=255)
     */
    private $familyName;

    /**
     * @var string
     *
     * @ORM\Column(name="givenName", type="string", length=255)
     */
    private $givenName;

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
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     *
     * @Assert\File(mimeTypes={"application/png", "application/jpeg"})
     */
    private $picture;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="person")
     * @ORM\JoinColumn(name="user_id", nullable=true, fieldName="id")
     */
    private $user;

    /**
     * @var Scout
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Scout", mappedBy="person")
     */
    private $scout;

    /**
     * @var Talent
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Talent", mappedBy="person")
     */
    private $talent;

    /**
     * Person constructor.
     *
     * @param string         $familyName
     * @param string         $givenName
     * @param string|null    $address
     * @param string|null    $phone
     * @param string|null    $mail
     * @param \DateTime|null $birthDate
     */
    public function __construct(
        string $familyName,
        string $givenName,
        string $address = null,
        string $phone = null,
        string $mail = null,
        \DateTime $birthDate = null
    ) {
        $this->familyName = $familyName;
        $this->givenName = $givenName;
        $this->address = $address;
        $this->phone = $phone;
        $this->mail = $mail;
        $this->birthDate = $birthDate;
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
     * Set familyName.
     *
     * @param string $familyName
     *
     * @return Person
     */
    public function setFamilyName(string $familyName): Person
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * Get familyName.
     *
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * Set givenName.
     *
     * @param string $givenName
     *
     * @return Person
     */
    public function setGivenName(string $givenName): Person
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * Get givenName.
     *
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Person
     */
    public function setAddress(string $address = null): Person
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Set address2.
     *
     * @param string $address2
     *
     * @return Person
     */
    public function setAddress2(string $address2 = null): Person
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
     * @return Person
     */
    public function setPostcode(Postcode $postcode = null): Person
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
     * Set phone.
     *
     * @param string $phone
     *
     * @return Person
     */
    public function setPhone(string $phone = null): Person
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail(string $email = null): Person
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set birthDate.
     *
     * @param \DateTime $birthDate
     *
     * @return Person
     */
    public function setBirthDate(\DateTime $birthDate = null): Person
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate.
     *
     * @return \DateTime|null
     */
    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    /**
     * Set picture.
     *
     * @param string $picture
     *
     * @return Person
     */
    public function setPicture(string $picture = null): Person
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Person
     */
    public function setUser(User $user = null): Person
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set scout.
     *
     * @param Scout $scout
     *
     * @return Person
     */
    public function setScout(Scout $scout = null): Person
    {
        $this->scout = $scout;

        return $this;
    }

    /**
     * Get scout.
     *
     * @return Scout|null
     */
    public function getScout(): Scout
    {
        return $this->scout;
    }

    /**
     * Is scout.
     *
     * @return bool
     */
    public function isScout(): bool
    {
        return $this->scout ? true : false;
    }

    /**
     * Set talent.
     *
     * @param Talent $talent
     *
     * @return Person
     */
    public function setTalent(Talent $talent = null): Person
    {
        $this->talent = $talent;

        return $this;
    }

    /**
     * Get talent.
     *
     * @return Talent|null
     */
    public function getTalent(): Talent
    {
        return $this->talent;
    }

    /**
     * Is talent.
     *
     * @return bool
     */
    public function isTalent(): bool
    {
        return $this->talent ? true : false;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getGivenName(). ' '. $this->getFamilyName();
    }
}
