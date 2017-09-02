<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode.
 *
 * @ORM\Table(name="postcodes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostcodeRepository")
 */
class Postcode
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
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var resource
     *
     * @ORM\Column(name="city", type="blob")
     */
    private $city;

    /**
     * @var Province
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Province", inversedBy="postcodes", cascade={"persist"})
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
    private $province;

    /**
     * Postcode constructor.
     *
     * @param int    $id
     * @param string $postcode
     * @param string $city
     */
    public function __construct(int $id, string $postcode, string $city)
    {
        $this->id = $id;
        $this->postcode = $postcode;
        $this->city = $city;
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
     * Set postcode.
     *
     * @param string $postcode
     *
     * @return Postcode
     */
    public function setPostcode($postcode): Postcode
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode.
     *
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * Set city.
     *
     * @param resource $city
     *
     * @return Postcode
     */
    public function setCity($city): Postcode
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity(): string
    {
        return utf8_encode($this->city);
    }

    /**
     * Set province.
     *
     * @param Province $province
     *
     * @return Postcode
     */
    public function setProvince(Province $province): Postcode
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province.
     *
     * @return Province
     */
    public function getProvince(): ?Province
    {
        return $this->province;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPostcode(). ' '.$this->getCity();
    }
}
