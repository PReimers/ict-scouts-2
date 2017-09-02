<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Module.
 *
 * @ORM\Table(name="modules")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleRepository")
 */
class Module
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Scout", mappedBy="modules", cascade={"all"})
     */
    private $scouts;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ModulePart", mappedBy="module", cascade={"all"})
     */
    private $moduleParts;

    /**
     * Module constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->scouts = new ArrayCollection();
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
     * @return Module
     */
    public function setName(string $name): Module
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
     * Add scout.
     *
     * @param Scout $scout
     */
    public function addScout(Scout $scout): void
    {
        if (!$this->scouts->contains($scout)) {
            $this->scouts->add($scout);
        }
    }

    /**
     * Remove scout.
     *
     * @param Scout $scout
     */
    public function removeScout(Scout $scout): void
    {
        $this->scouts->removeElement($scout);
    }

    /**
     * Get scouts.
     *
     * @return Collection
     */
    public function getScouts(): Collection
    {
        return $this->scouts;
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
     * @return Collection|null
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
