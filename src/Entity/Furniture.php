<?php

namespace App\Entity;

use App\Repository\FurnitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FurnitureRepository::class)]
class Furniture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimesion = null;

    #[ORM\ManyToOne(inversedBy: 'furniture')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categoy = null;

    #[ORM\OneToMany(mappedBy: 'furniture', targetEntity: Photos::class)]
    private Collection $photos;

    #[ORM\ManyToMany(targetEntity: Materials::class, mappedBy: 'furniture')]
    private Collection $materials;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->materials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDimesion(): ?string
    {
        return $this->dimesion;
    }

    public function setDimesion(?string $dimesion): self
    {
        $this->dimesion = $dimesion;

        return $this;
    }

    public function getCategoy(): ?Categories
    {
        return $this->categoy;
    }

    public function setCategoy(?Categories $categoy): self
    {
        $this->categoy = $categoy;

        return $this;
    }

    /**
     * @return Collection<int, Photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setFurniture($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getFurniture() === $this) {
                $photo->setFurniture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Materials>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Materials $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials->add($material);
            $material->addFurniture($this);
        }

        return $this;
    }

    public function removeMaterial(Materials $material): self
    {
        if ($this->materials->removeElement($material)) {
            $material->removeFurniture($this);
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
