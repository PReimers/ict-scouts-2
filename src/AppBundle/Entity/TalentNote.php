<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TalentNote
 *
 * @ORM\Table(name="talent_notes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TalentNotesRepository")
 */
class TalentNote
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
     * @ORM\Column(name="note", type="text")
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Talent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Talent", inversedBy="talentNotes")
     * @ORM\JoinColumn(name="talent_id", fieldName="id")
     */
    private $talent;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="talentNotes")
     * @ORM\JoinColumn(name="user_id", fieldName="id")
     */
    private $user;


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
     * Set note.
     *
     * @param string $note
     *
     * @return TalentNote
     */
    public function setNote(string $note): TalentNote
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return TalentNote
     */
    public function setDate(\DateTime $date = null): TalentNote
    {
        $this->date = $date ?: new \DateTime();

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * Set talent.
     *
     * @param Talent $talent
     *
     * @return TalentNote
     */
    public function setTalent(Talent $talent): TalentNote
    {
        $this->talent = $talent;

        return $this;
    }

    /**
     * Get talent.
     *
     * @return Talent
     */
    public function getTalent(): Talent
    {
        return $this->talent;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return TalentNote
     */
    public function setUser(User $user): TalentNote
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
