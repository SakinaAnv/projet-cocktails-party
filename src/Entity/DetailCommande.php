<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailCommande
 *
 * @ORM\Table(name="detail_commande")
 * @ORM\Entity(repositoryClass="App\Repository\DetailCommandeRepository")
 */
class DetailCommande
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
     * @var int
     *
     * @ORM\Column(name="idCocktail", type="integer", nullable=false)
     */
    private $idcocktail;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="num_commande", type="integer", nullable=true)
     */
    private $numCommande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdcocktail(): ?int
    {
        return $this->idcocktail;
    }

    public function setIdcocktail(int $idcocktail): self
    {
        $this->idcocktail = $idcocktail;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getNumCommande(): ?int
    {
        return $this->numCommande;
    }

    public function setNumCommande(?int $numCommande): self
    {
        $this->numCommande = $numCommande;

        return $this;
    }


}
