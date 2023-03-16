<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ColorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorsRepository::class)]
#[ApiResource]
class Colors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\ManyToMany(targetEntity: Meubles::class, inversedBy: 'meuble_id')]
    private Collection $meuble;

    public function __construct()
    {
        $this->meuble = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Meubles>
     */
    public function getMeuble(): Collection
    {
        return $this->meuble;
    }

    public function addMeuble(Meubles $meuble): self
    {
        if (!$this->meuble->contains($meuble)) {
            $this->meuble->add($meuble);
        }

        return $this;
    }

    public function removeMeuble(Meubles $meuble): self
    {
        $this->meuble->removeElement($meuble);

        return $this;
    }
}