<?php

namespace App\Entity;

use App\Repository\InterestMarksRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=InterestMarksRepository::class)
 */
class InterestMarks
{
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"interests"})
     * @Groups({"projects"})
     * @ORM\Column(type="integer")
     */
    private $amountInvested;

    /**
     * @Groups({"projects"})
     * @Groups({"interests"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="interestMarks", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     *
     * @Groups({"interests"})
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="interestMarks", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmountInvested(): ?int
    {
        return $this->amountInvested;
    }

    public function setAmountInvested(int $amountInvested): self
    {
        $this->amountInvested = $amountInvested;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
