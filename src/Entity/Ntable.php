<?php

namespace App\Entity;

use App\Repository\NtableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NtableRepository::class)]
class Ntable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $accessibility;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccessibility(): ?bool
    {
        return $this->accessibility;
    }

    public function setAccessibility(bool $accessibility): self
    {
        $this->accessibility = $accessibility;

        return $this;
    }
}
