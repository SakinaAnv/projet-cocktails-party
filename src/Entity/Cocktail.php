<?php

namespace App\Entity;

use App\Repository\CocktailRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @UniqueEntity(fields={"name"}, message="Ce nom de cocktail existe déja ")
 */
#[ORM\Entity(repositoryClass: CocktailRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cocktail
{

    use TimeStampTrait;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[NotBlank]
    private ?string $name;

    #[NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[NotBlank]
    private $price;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imagePath;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $updatedAt;


    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'cocktails',cascade:['persist','remove'] )]
    #[ORM\JoinColumn(nullable: false)]
   # #[ORM\JoinTable(name:'cocktail_ingredient')]
    #[NotBlank]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'cocktails')]
    private $orders;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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




    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addCocktail($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            $order->removeCocktail($this);
        }

        return $this;
    }

}
