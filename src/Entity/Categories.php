<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
#[ApiResource]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\OneToMany(targetEntity: Meubles::class, mappedBy: 'categoryId')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Meubles::class)]
    private Collection $categoryId;

    public function __construct()
    {
        $this->categoryId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Meubles>
     */
    public function getCategoryId(): Collection
    {
        return $this->categoryId;
    }

    public function addCategoryId(Meubles $categoryId): self
    {
        if (!$this->categoryId->contains($categoryId)) {
            $this->categoryId->add($categoryId);
            $categoryId->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryId(Meubles $categoryId): self
    {
        if ($this->categoryId->removeElement($categoryId)) {
            // set the owning side to null (unless already changed)
            if ($categoryId->getCategory() === $this) {
                $categoryId->setCategory(null);
            }
        }

        return $this;
    }
}