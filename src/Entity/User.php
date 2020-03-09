<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="user_id")
     */
    private $ticket_created;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="agent_id")
     */
    private $ticket_handled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="commented_by")
     */
    private $comments_made;

    public function __construct()
    {
        $this->ticket_created = new ArrayCollection();
        $this->ticket_handled = new ArrayCollection();
        $this->comments_made = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicketCreated(): Collection
    {
        return $this->ticket_created;
    }

    public function addTicketCreated(Ticket $ticketCreated): self
    {
        if (!$this->ticket_created->contains($ticketCreated)) {
            $this->ticket_created[] = $ticketCreated;
            $ticketCreated->setUserId($this);
        }

        return $this;
    }

    public function removeTicketCreated(Ticket $ticketCreated): self
    {
        if ($this->ticket_created->contains($ticketCreated)) {
            $this->ticket_created->removeElement($ticketCreated);
            // set the owning side to null (unless already changed)
            if ($ticketCreated->getUserId() === $this) {
                $ticketCreated->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicketHandled(): Collection
    {
        return $this->ticket_handled;
    }

    public function addTicketHandled(Ticket $ticketHandled): self
    {
        if (!$this->ticket_handled->contains($ticketHandled)) {
            $this->ticket_handled[] = $ticketHandled;
            $ticketHandled->setAgentId($this);
        }

        return $this;
    }

    public function removeTicketHandled(Ticket $ticketHandled): self
    {
        if ($this->ticket_handled->contains($ticketHandled)) {
            $this->ticket_handled->removeElement($ticketHandled);
            // set the owning side to null (unless already changed)
            if ($ticketHandled->getAgentId() === $this) {
                $ticketHandled->setAgentId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommentsMade(): Collection
    {
        return $this->comments_made;
    }

    public function addCommentsMade(Comment $commentsMade): self
    {
        if (!$this->comments_made->contains($commentsMade)) {
            $this->comments_made[] = $commentsMade;
            $commentsMade->setCommentedBy($this);
        }

        return $this;
    }

    public function removeCommentsMade(Comment $commentsMade): self
    {
        if ($this->comments_made->contains($commentsMade)) {
            $this->comments_made->removeElement($commentsMade);
            // set the owning side to null (unless already changed)
            if ($commentsMade->getCommentedBy() === $this) {
                $commentsMade->setCommentedBy(null);
            }
        }

        return $this;
    }
}
