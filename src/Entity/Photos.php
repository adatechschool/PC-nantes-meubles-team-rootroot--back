<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PhotosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
#[ApiResource]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $meubleId = null;

    #[ORM\Column(type: Types::BLOB)]
    private $content = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }
}
