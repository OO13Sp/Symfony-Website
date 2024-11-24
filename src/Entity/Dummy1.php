<?php

namespace App\Entity;

use App\Repository\Dummy1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Dummy1Repository::class)]
class Dummy1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $data = null;

    #[ORM\Column(length: 40)]
    private ?string $dummy2 = null;

    /**
     * @var Collection<int, Dummy2>
     */
    #[ORM\ManyToMany(targetEntity: Dummy2::class, inversedBy: 'dummy1s')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getDummy2(): ?string
    {
        return $this->dummy2;
    }

    public function setDummy2(string $dummy2): static
    {
        $this->dummy2 = $dummy2;

        return $this;
    }

    /**
     * @return Collection<int, Dummy2>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Dummy2 $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
        }

        return $this;
    }

    public function removeRelation(Dummy2 $relation): static
    {
        $this->relation->removeElement($relation);

        return $this;
    }
}
