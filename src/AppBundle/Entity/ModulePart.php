<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModulePart
 *
 * @ORM\Table(name="module_parts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModulePartRepository")
 */
class ModulePart
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
     * @var Module
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module", inversedBy="moduleParts", cascade={"all"})
     * @ORM\JoinColumn(name="module_id", nullable=false, fieldName="id")
     */
    private $module;

    /**
     * @var Camp
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Camp", inversedBy="moduleParts", cascade={"all"})
     * @ORM\JoinColumn(name="camp_id", nullable=true, fieldName="id")
     */
    private $camp;

    /**
     * @var Workshop
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Workshop", inversedBy="moduleParts", cascade={"all"})
     * @ORM\JoinColumn(name="workshop_id", nullable=true, fieldName="id")
     */
    private $workshop;

    /**
     * @var Cast
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cast", inversedBy="moduleParts", cascade={"all"})
     * @ORM\JoinColumn(name="cast_id", nullable=true, fieldName="id")
     */
    private $cast;

    /**
     * ModulePart constructor.
     *
     * @param Module $module
     * @param string $name
     */
    public function __construct(Module $module, string $name)
    {
        $this->module = $module;
        $this->name = $name;
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
     * @return ModulePart
     */
    public function setName($name): ModulePart
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
     * Set module.
     *
     * @param Module $module
     */
    public function setModule(Module $module): void
    {
        $this->module = $module;
    }

    /**
     * Get module.
     *
     * @return Module
     */
    public function getModule(): ?Module
    {
        return $this->module;
    }

    /**
     * Set camp.
     *
     * @param Camp $camp
     *
     * @return ModulePart
     */
    public function setCamp(Camp $camp = null): ModulePart
    {
        $this->camp = $camp;

        return $this;
    }

    /**
     * Get camp.
     *
     * @return Camp
     */
    public function getCamp(): ?Camp
    {
        return $this->camp;
    }

    /**
     * Set workshop.
     *
     * @param Workshop $workshop
     *
     * @return ModulePart
     */
    public function setWorkshop(Workshop $workshop = null): ModulePart
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * Get workshop.
     *
     * @return Workshop
     */
    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    /**
     * Set cast.
     *
     * @param Cast $cast
     *
     * @return ModulePart
     */
    public function setCast(Cast $cast = null): ModulePart
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * Get cast.
     *
     * @return Cast
     */
    public function getCast(): ?Cast
    {
        return $this->cast;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
