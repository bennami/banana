<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $priority;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ticket_created")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $agent_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="ticket")
     */
    private $comment_id;


    public function __construct()
    {
        $this->comment_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate( $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getAgentId(): ?User
    {
        return $this->agent_id;
    }

    public function setAgentId(?User $agent_id): self
    {
        $this->agent_id = $agent_id;

        return $this;
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

    /**
     * @return Collection|Comment[]
     */
    public function getCommentId(): Collection
    {
        return $this->comment_id;
    }

    public function addCommentId(Comment $commentId): self
    {
        if (!$this->comment_id->contains($commentId)) {
            $this->comment_id[] = $commentId;
            $commentId->setTicket($this);
        }

        return $this;
    }

    public function removeCommentId(Comment $commentId): self
    {
        if ($this->comment_id->contains($commentId)) {
            $this->comment_id->removeElement($commentId);
            // set the owning side to null (unless already changed)
            if ($commentId->getTicket() === $this) {
                $commentId->setTicket(null);
            }
        }

        return $this;
    }


}
