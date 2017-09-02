<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Talent
 *
 * @ORM\Table(name="talents")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TalentRepository")
 */
class Talent
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
     * @var bool
     *
     * @ORM\Column(name="veggie", type="boolean")
     */
    private $veggie;

    /**
     * @var Person
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Person", inversedBy="talent", cascade={"all"})
     * @ORM\JoinColumn(name="person_id", fieldName="id")
     */
    private $person;

    /**
     * @var School
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\School", inversedBy="talents", cascade={"all"})
     * @ORM\JoinColumn(name="school_id", nullable=true, fieldName="id")
     */
    private $school;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TalentStatusHistory", mappedBy="talent")
     */
    private $talentStatusHistories;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TalentNote", mappedBy="talent")
     */
    private $talentNotes;

    public function __construct(Person $person, bool $veggie=false)
    {
        $this->person = $person;
        $this->veggie = $veggie;
        $this->talentStatusHistories = new ArrayCollection();
        $this->talentNotes = new ArrayCollection();
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
     * Set veggie.
     *
     * @param boolean $veggie
     *
     * @return Talent
     */
    public function setVeggie($veggie): Talent
    {
        $this->veggie = $veggie;

        return $this;
    }

    /**
     * Get veggie.
     *
     * @return bool
     */
    public function getVeggie(): bool
    {
        return $this->veggie;
    }

    /**
     * Set person.
     *
     * @param Person $person
     *
     * @return Talent
     */
    public function setPerson(Person $person): Talent
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
     * Set school.
     *
     * @param School $school
     */
    public function setSchool(School $school = null): void
    {
        $this->school = $school;
    }

    /**
     * Get school.
     *
     * @return School
     */
    public function getSchool(): ?School
    {
        return $this->school;
    }

    /**
     * Add talent status history.
     *
     * @param TalentStatusHistory $talentStatusHistory
     */
    public function addTalentStatusHistory(TalentStatusHistory $talentStatusHistory): void
    {
        if (!$this->talentStatusHistories->contains($talentStatusHistory)) {
            $this->talentStatusHistories->add($talentStatusHistory);
        }
    }

    /**
     * Remove talent status history.
     *
     * @param TalentStatusHistory $talentStatusHistory
     */
    public function removeTalentStatusHistory(TalentStatusHistory $talentStatusHistory): void
    {
        $this->talentStatusHistories->removeElement($talentStatusHistory);
    }

    /**
     * Get talent status histories.
     *
     * @return Collection|null
     */
    public function getTalentStatusHistories(): ?Collection
    {
        return $this->talentStatusHistories;
    }

    /**
     * Get talent status.
     *
     * @return int|null
     */
    public function getTalentStatus(): ?int
    {
        $status = null;
        $lastChange = new \DateTime('1900-01-01');
        /** @var TalentStatusHistory $statusEntry */
        foreach ($this->talentStatusHistories AS $statusEntry) {
            if ($statusEntry->getChangeDate() >= $lastChange) {
                $status = $statusEntry->getStatus();
            }
        }

        return $status;
    }

    /**
     * Add talent note.
     *
     * @param TalentNote $talentNote
     */
    public function addTalentNote(TalentNote $talentNote): void
    {
        if (!$this->talentNotes->contains($talentNote)) {
            $this->talentNotes->add($talentNote);
        }
    }

    /**
     * Remove talent note.
     *
     * @param TalentNote $talentNote
     */
    public function removeTalentNote(TalentNote $talentNote): void
    {
        $this->talentNotes->removeElement($talentNote);
    }

    /**
     * Get talent notes.
     *
     * @return Collection|null
     */
    public function getTalentNotes(): ?Collection
    {
        return $this->talentNotes;
    }
}
