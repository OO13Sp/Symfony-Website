<?php

namespace App\Entity;

use App\Repository\Dummy2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Dummy2Repository::class)]
class Dummy2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    /**
     * @var Collection<int, Dummy1>
     */
    #[ORM\ManyToMany(targetEntity: Dummy1::class, mappedBy: 'relation')]
    private Collection $dummy1s;

    public function __construct()
    {
        $this->dummy1s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Dummy1>
     */
    public function getDummy1s(): Collection
    {
        return $this->dummy1s;
    }

    public function addDummy1(Dummy1 $dummy1): static
    {
        if (!$this->dummy1s->contains($dummy1)) {
            $this->dummy1s->add($dummy1);
            $dummy1->addRelation($this);
        }

        return $this;
    }

    public function removeDummy1(Dummy1 $dummy1): static
    {
        if ($this->dummy1s->removeElement($dummy1)) {
            $dummy1->removeRelation($this);
        }

        return $this;
    }
}
