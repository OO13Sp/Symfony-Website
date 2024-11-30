<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgURL = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'Product_Type')]
    private Collection $Categories;

    #[ORM\ManyToOne(inversedBy: 'Products_Order')]
    private ?Order $Product_Orders = null;

    #[ORM\ManyToOne(inversedBy: 'Product_Sale')]
    private ?Sale $Product_Sales = null;

    public function __construct()
    {
        $this->Categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImgURL(): ?string
    {
        return $this->imgURL;
    }

    public function setImgURL(?string $imgURL): static
    {
        $this->imgURL = $imgURL;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->Categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->Categories->contains($category)) {
            $this->Categories->add($category);
            $category->addProductType($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->Categories->removeElement($category)) {
            $category->removeProductType($this);
        }

        return $this;
    }

    public function getProductOrders(): ?Order
    {
        return $this->Product_Orders;
    }

    public function setProductOrders(?Order $Product_Orders): static
    {
        $this->Product_Orders = $Product_Orders;

        return $this;
    }

    public function getProductSales(): ?Sale
    {
        return $this->Product_Sales;
    }

    public function setProductSales(?Sale $Product_Sales): static
    {
        $this->Product_Sales = $Product_Sales;

        return $this;
    }
}
