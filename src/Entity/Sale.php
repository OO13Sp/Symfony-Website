<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $saleDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalAmount = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'Product_Sales')]
    private Collection $Product_Sale;

    public function __construct()
    {
        $this->Product_Sale = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->saleDate;
    }

    public function setSaleDate(\DateTimeInterface $saleDate): static
    {
        $this->saleDate = $saleDate;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductSale(): Collection
    {
        return $this->Product_Sale;
    }

    public function addProductSale(Product $productSale): static
    {
        if (!$this->Product_Sale->contains($productSale)) {
            $this->Product_Sale->add($productSale);
            $productSale->setProductSales($this);
        }

        return $this;
    }

    public function removeProductSale(Product $productSale): static
    {
        if ($this->Product_Sale->removeElement($productSale)) {
            // set the owning side to null (unless already changed)
            if ($productSale->getProductSales() === $this) {
                $productSale->setProductSales(null);
            }
        }

        return $this;
    }
}
