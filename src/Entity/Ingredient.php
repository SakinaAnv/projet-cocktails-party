<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * @UniqueEntity(fields={"name"}, message="There is already this ingredient ")
 */
#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Ingredient
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[NotBlank]
    /**
     * @Assert\Regex(
     *      pattern     = "/^\d+(,\d{1,2})?$/",
     *     htmlPattern = "\d{1,3}(?:[.,]\d{3})*(?:[.,]\d{2})")
     *
     */
    private $price;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[NotBlank]
    private ?string $name;

    #[ORM\Column(type: 'integer')]
    #[NotBlank]
    /**
     * @Assert\Positive
     */
    private ?int $inventoryQuantity;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imagePath;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $updatedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $deletedAt;

    #[ORM\ManyToMany(targetEntity: Cocktail::class, mappedBy: 'ingredients')]
    private Collection $cocktails;

    public function __construct()
    {
        $this->cocktails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
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

    public function getInventoryQuantity(): ?int
    {
        return $this->inventoryQuantity;
    }

    public function setInventoryQuantity(int $inventoryQuantity): self
    {
        $this->inventoryQuantity = $inventoryQuantity;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|Cocktail[]
     */
    public function getCocktails(): Collection
    {
        return $this->cocktails;
    }

    public function addCocktail(Cocktail $cocktail): self
    {
        if (!$this->cocktails->contains($cocktail)) {
            $this->cocktails[] = $cocktail;
            $cocktail->addIngredient($this);
        }

        return $this;
    }

    public function removeCocktail(Cocktail $cocktail): self
    {
        if ($this->cocktails->removeElement($cocktail)) {
            $cocktail->removeIngredient($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }
}
