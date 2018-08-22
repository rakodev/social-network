<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserBand", mappedBy="userId")
     */
    private $userBands;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserUser", mappedBy="userIdA")
     */
    private $userUsers;

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
        $this->userUsers = new ArrayCollection();
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
            $userBand->setUser($this);
        }

        return $this;
    }

    public function removeUserBand(UserBand $userBand): self
    {
        if ($this->userBands->contains($userBand)) {
            $this->userBands->removeElement($userBand);
            // set the owning side to null (unless already changed)
            if ($userBand->getUser() === $this) {
                $userBand->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserUser[]
     */
    public function getUserUsers(): Collection
    {
        return $this->userUsers;
    }

    public function addUserUser(UserUser $userUser): self
    {
        if (!$this->userUsers->contains($userUser)) {
            $this->userUsers[] = $userUser;
            $userUser->setUserA($this);
        }

        return $this;
    }

    public function removeUserUser(UserUser $userUser): self
    {
        if ($this->userUsers->contains($userUser)) {
            $this->userUsers->removeElement($userUser);
            // set the owning side to null (unless already changed)
            if ($userUser->getUserA() === $this) {
                $userUser->setUserA(null);
            }
        }

        return $this;
    }
}
