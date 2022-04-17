<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ntable
 *
 * @ORM\Table(name="ntable")
 * @ORM\Entity(repositoryClass="App\Repository\NtableRepository")
 */
class Ntable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="accessibility", type="boolean", nullable=false)
     */
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
