<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TalentStatusHistory
 *
 * @ORM\Table(name="talent_status_histories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TalentStatusHistoryRepository")
 */
class TalentStatusHistory
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
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changeDate", type="datetime")
     */
    private $changeDate;

    /**
     * @var Talent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Talent", inversedBy="talentStatusHistories")
     * @ORM\JoinColumn(name="talent_id", fieldName="id")
     */
    private $talent;

    /**
     * TalentStatusHistory constructor.
     *
     * @param Talent    $talent
     * @param int       $status
     * @param \DateTime $date   (optional)
     */
    public function __construct(Talent $talent, int $status, \DateTime $date = null)
    {
        $this->talent = $talent;
        $this->status = $status;
        $this->changeDate = ($date ?: new \DateTime());
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
     * Set status.
     *
     * @param integer $status
     *
     * @return TalentStatusHistory
     */
    public function setStatus(int $status): TalentStatusHistory
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set changeDate.
     *
     * @param \DateTime $changeDate
     *
     * @return TalentStatusHistory
     */
    public function setChangeDate($changeDate): TalentStatusHistory
    {
        $this->changeDate = $changeDate;

        return $this;
    }

    /**
     * Get changeDate.
     *
     * @return \DateTime
     */
    public function getChangeDate(): \DateTime
    {
        return $this->changeDate;
    }

    /**
     * Set talent.
     *
     * @param Talent $talent
     *
     * @return TalentStatusHistory
     */
    public function setTalent(Talent $talent): TalentStatusHistory
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
}
