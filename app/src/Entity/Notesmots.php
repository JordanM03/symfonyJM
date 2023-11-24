<?php

namespace App\Entity;

use App\Repository\NotesmotsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesmotsRepository::class)]
class Notesmots
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mot = null;

    #[ORM\Column(nullable: true)]
    private ?int $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(string $mot): static
    {
        $this->mot = $mot;

        return $this;
    }

    public function getNotes(): ?int
    {
        return $this->notes;
    }

    public function setNotes(?int $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
}
