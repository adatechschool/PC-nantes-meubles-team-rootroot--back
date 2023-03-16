<?php

namespace App\Entity;

use App\Repository\MeublesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeublesRepository::class)]
class Meubles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'categoryId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?string $dimension = null;

    #[ORM\ManyToMany(targetEntity: Colors::class, mappedBy: 'meuble')]
    private Collection $meuble_id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Material = null;

    #[ORM\Column(length: 255)]
    private ?string $Picture = null;

    public function __construct()
    {
        $this->meuble_id = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }


    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDimension(): ?int
    {
        return $this->dimension;
    }

    public function setDimension(int $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return Collection<int, Colors>
     */
    public function getMeubleId(): Collection
    {
        return $this->meuble_id;
    }

    public function addMeubleId(Colors $meubleId): self
    {
        if (!$this->meuble_id->contains($meubleId)) {
            $this->meuble_id->add($meubleId);
            $meubleId->addMeuble($this);
        }

        return $this;
    }

    public function removeMeubleId(Colors $meubleId): self
    {
        if ($this->meuble_id->removeElement($meubleId)) {
            $meubleId->removeMeuble($this);
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(?string $Color): self
    {
        $this->Color = $Color;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->Material;
    }

    public function setMaterial(?string $Material): self
    {
        $this->Material = $Material;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->Picture;
    }

    public function setPicture(string $Picture): self
    {
        $this->Picture = $Picture;

        return $this;
    }

}