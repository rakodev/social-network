<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserUserRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="relation",
 *          columns={"user_a_id", "user_b_id"})
 * })
 */
class UserUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userA;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userB;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserA(): ?user
    {
        return $this->userA;
    }

    public function setUserA(?user $userA): self
    {
        $this->userA = $userA;

        return $this;
    }

    public function getUserB(): ?user
    {
        return $this->userB;
    }

    public function setUserB(?user $userB): self
    {
        $this->userB = $userB;

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
}
