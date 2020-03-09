<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Timestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private $TicketID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Comment;

    /**
     * @ORM\Column(type="integer")
     */
    private $Commented_By;

    /**
     * Comment constructor.
     * @param $Timestamp
     * @param $TicketID
     * @param $Comment
     * @param $Commented_By
     */
    public function __construct($Timestamp, $TicketID, $Comment, $Commented_By)
    {
        $this->Timestamp = $Timestamp;
        $this->TicketID = $TicketID;
        $this->Comment = $Comment;
        $this->Commented_By = $Commented_By;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $ID): self
    {
        $this->ID = $ID;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->Timestamp;
    }

    public function setTimestamp(\DateTimeInterface $Timestamp): self
    {
        $this->Timestamp = $Timestamp;

        return $this;
    }

    public function getTicketID(): ?int
    {
        return $this->TicketID;
    }

    public function setTicketID(int $TicketID): self
    {
        $this->TicketID = $TicketID;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(string $Comment): self
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function getCommentedBy(): ?int
    {
        return $this->Commented_By;
    }

    public function setCommentedBy(int $Commented_By): self
    {
        $this->Commented_By = $Commented_By;

        return $this;
    }
}
