<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 */
class Ingredient
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
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="inventoryQuantity", type="integer", nullable=false)
     */
    private $inventoryquantity;

    /**
     * @var string
     *
     * @ORM\Column(name="imagePath", type="string", length=255, nullable=false)
     */
    private $imagepath;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="createdAt", type="datetime_immutable", nullable=false, options={"comment"="	"})
     */
    private $createdat;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="updateAt", type="datetime_immutable", nullable=false, options={"comment"="	"})
     */
    private $updateat;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="deletedAt", type="datetime_immutable", nullable=false)
     */
    private $deletedat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInventoryquantity(): ?int
    {
        return $this->inventoryquantity;
    }

    public function setInventoryquantity(int $inventoryquantity): self
    {
        $this->inventoryquantity = $inventoryquantity;

        return $this;
    }

    public function getImagepath(): ?string
    {
        return $this->imagepath;
    }

    public function setImagepath(string $imagepath): self
    {
        $this->imagepath = $imagepath;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeImmutable
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeImmutable $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdateat(): ?\DateTimeImmutable
    {
        return $this->updateat;
    }

    public function setUpdateat(\DateTimeImmutable $updateat): self
    {
        $this->updateat = $updateat;

        return $this;
    }

    public function getDeletedat(): ?\DateTimeImmutable
    {
        return $this->deletedat;
    }

    public function setDeletedat(\DateTimeImmutable $deletedat): self
    {
        $this->deletedat = $deletedat;

        return $this;
    }


}
