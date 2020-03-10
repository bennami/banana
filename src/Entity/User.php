<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="user_id")
     */
    private $ticket_created;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="commented_by")
     */
    private $comments_made;

    public function __construct()
    {
        $this->ticket_created = new ArrayCollection();
        $this->comments_made = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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