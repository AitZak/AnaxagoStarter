<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    const STATUS = ['financé', 'non-financé'];

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
     * @Groups("projects")
     * @Assert\NotBlank()
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @Groups("projects")
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Groups("projects")
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @Groups("projects")
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $triggeringTreshold;

    /**
     * @ORM\OneToMany(targetEntity=InterestMarks::class, mappedBy="project")
     */
    private $interestMarks;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $funding;

    public function __construct()
    {
        $this->interestMarks = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Project
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTriggeringTreshold(): ?int
    {
        return $this->triggeringTreshold;
    }

    public function setTriggeringTreshold(?int $triggeringTreshold): self
    {
        $this->triggeringTreshold = $triggeringTreshold;

        return $this;
    }

    /**
     * @return Collection|InterestMarks[]
     */
    public function getInterestMarks(): Collection
    {
        return $this->interestMarks;
    }

    public function addInterestMark(InterestMarks $interestMark): self
    {
        if (!$this->interestMarks->contains($interestMark)) {
            $this->interestMarks[] = $interestMark;
            $interestMark->setProject($this);
        }

        return $this;
    }

    public function removeInterestMark(InterestMarks $interestMark): self
    {
        if ($this->interestMarks->contains($interestMark)) {
            $this->interestMarks->removeElement($interestMark);
            // set the owning side to null (unless already changed)
            if ($interestMark->getProject() === $this) {
                $interestMark->setProject(null);
            }
        }

        return $this;
    }

    public function getFunding(): ?int
    {
        return $this->funding;
    }

    public function setFunding(?int $funding): self
    {
        $this->funding = $funding;

        return $this;
    }
}

