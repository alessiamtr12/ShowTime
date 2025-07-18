<?php

namespace App\Entity;

use App\Enum\MusicGenre;
use App\Repository\BandRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Band name cannot be blank')]
    private ?string $name = null;

    #[ORM\Column(enumType: MusicGenre::class)]
    #[Assert\NotBlank(message: 'Genre cannot be blank')]
    private ?MusicGenre $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGenre(): ?MusicGenre
    {
        return $this->genre;
    }

    public function setGenre(MusicGenre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}
