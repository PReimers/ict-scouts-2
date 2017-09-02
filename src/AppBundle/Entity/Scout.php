<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Scout.
 *
 * @ORM\Table(name="scouts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScoutRepository")
 */
class Scout
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
     * @var Person
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Person", inversedBy="scout", cascade={"all"})
     * @ORM\JoinColumn(name="person_id", fieldName="id")
     */
    private $person;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Module", inversedBy="scouts", cascade={"all"})
     * @ORM\JoinTable(
     *     name="scout_has_modules", joinColumns={
     *          @ORM\JoinColumn(name="scout_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     *     }
     * )
     */
    private $modules;

    /**
     * Scout constructor.
     *
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
        $this->modules = new ArrayCollection();
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
     * Set person.
     *
     * @param Person $person
     *
     * @return Scout
     */
    public function setPerson(Person $person): Scout
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person.
     *
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * Add module.
     *
     * @param Module $module
     */
    public function addModule(Module $module): void
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
        }
    }

    /**
     * Remove module.
     *
     * @param Module $module
     */
    public function removeModule(Module $module): void
    {
        $this->modules->removeElement($module);
    }

    /**
     * Get modules.
     *
     * @return Collection
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }
}
