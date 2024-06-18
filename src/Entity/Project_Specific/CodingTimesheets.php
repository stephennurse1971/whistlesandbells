<?php

namespace App\Entity\Project_Specific;

use App\Repository\Project_Specific\CodingTimesheetsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CodingTimesheetsRepository::class)
 */
class CodingTimesheets
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startTimeProposed;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $endTimeProposed;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startTimeActual;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $endTimeActual;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notesSN;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notesAdmin;

    /**
     * @ORM\Column(type="float",  nullable=true)
     */
    private $additionalHours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTimeProposed(): ?\DateTimeInterface
    {
        return $this->startTimeProposed;
    }

    public function setStartTimeProposed(?\DateTimeInterface $startTimeProposed): self
    {
        $this->startTimeProposed = $startTimeProposed;

        return $this;
    }

    public function getEndTimeProposed(): ?\DateTimeInterface
    {
        return $this->endTimeProposed;
    }

    public function setEndTimeProposed(?\DateTimeInterface $endTimeProposed): self
    {
        $this->endTimeProposed = $endTimeProposed;

        return $this;
    }

    public function getStartTimeActual(): ?\DateTimeInterface
    {
        return $this->startTimeActual;
    }

    public function setStartTimeActual(?\DateTimeInterface $startTimeActual): self
    {
        $this->startTimeActual = $startTimeActual;

        return $this;
    }

    public function getEndTimeActual(): ?\DateTimeInterface
    {
        return $this->endTimeActual;
    }

    public function setEndTimeActual(?\DateTimeInterface $endTimeActual): self
    {
        $this->endTimeActual = $endTimeActual;

        return $this;
    }



    public function getNotesSN(): ?string
    {
        return $this->notesSN;
    }

    public function setNotesSN(?string $notesSN): self
    {
        $this->notesSN = $notesSN;

        return $this;
    }

    public function getNotesAdmin(): ?string
    {
        return $this->notesAdmin;
    }

    public function setNotesAdmin(?string $notesAdmin): self
    {
        $this->notesAdmin = $notesAdmin;

        return $this;
    }

    public function getAdditionalHours(): ?string
    {
        return $this->additionalHours;
    }

    public function setAdditionalHours(?string $additionalHours): self
    {
        $this->additionalHours = $additionalHours;

        return $this;
    }
}
