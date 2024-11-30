<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'Product_Orders')]
    private Collection $Products_Order;

    public function __construct()
    {
        $this->Products_Order = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTimeInterface $Created_at): static
    {
        $this->Created_at = $Created_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsOrder(): Collection
    {
        return $this->Products_Order;
    }

    public function addProductsOrder(Product $productsOrder): static
    {
        if (!$this->Products_Order->contains($productsOrder)) {
            $this->Products_Order->add($productsOrder);
            $productsOrder->setProductOrders($this);
        }

        return $this;
    }

    public function removeProductsOrder(Product $productsOrder): static
    {
        if ($this->Products_Order->removeElement($productsOrder)) {
            // set the owning side to null (unless already changed)
            if ($productsOrder->getProductOrders() === $this) {
                $productsOrder->setProductOrders(null);
            }
        }

        return $this;
    }
}
