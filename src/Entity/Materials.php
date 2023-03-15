<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MaterialsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialsRepository::class)]
#[ApiResource]
class Materials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $material = null;

    #[ORM\Column]
    private ?int $meubleId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getMeubleId(): ?int
    {
        return $this->meubleId;
    }

    public function setMeubleId(int $meubleId): self
    {
        $this->meubleId = $meubleId;

        return $this;
    }
}
