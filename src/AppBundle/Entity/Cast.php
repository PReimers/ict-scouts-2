<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cast
 *
 * @ORM\Table(name="casts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CastRepository")
 */
class Cast
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ModulePart", mappedBy="cast", cascade={"all"})
     */
    private $moduleParts;

    /**
     * Cast constructor.
     *
     * @param string $name
     * @param string $url
     */
    public function __construct(string $name, string $url)
    {
        $this->name = $name;
        $this->url = $url;
        $this->moduleParts = new ArrayCollection();
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
     * @return Cast
     */
    public function setName(string $name): Cast
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
     * Set url.
     *
     * @param string $url
     *
     * @return Cast
     */
    public function setUrl(string $url): Cast
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
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
}
