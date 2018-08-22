<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BandRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="name",
 *          columns={"name"})
 * })
 */
class Band
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserBand", mappedBy="bandId")
     */
    private $userBands;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->userBands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|UserBand[]
     */
    public function getUserBands(): Collection
    {
        return $this->userBands;
    }

    public function addUserBand(UserBand $userBand): self
    {
        if (!$this->userBands->contains($userBand)) {
            $this->userBands[] = $userBand;
            $userBand->setBand($this);
        }

        return $this;
    }

    public function removeUserBand(UserBand $userBand): self
    {
        if ($this->userBands->contains($userBand)) {
            $this->userBands->removeElement($userBand);
            // set the owning side to null (unless already changed)
            if ($userBand->getBand() === $this) {
                $userBand->setBand(null);
            }
        }

        return $this;
    }
}
