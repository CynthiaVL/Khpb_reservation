<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
class Discount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $min_day = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_day = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount_rate = null;

    /**
     * @var Collection<int, Property>
     */
    #[ORM\ManyToMany(targetEntity: Property::class, mappedBy: 'discount')]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinDay(): ?int
    {
        return $this->min_day;
    }

    public function setMinDay(?int $min_day): static
    {
        $this->min_day = $min_day;

        return $this;
    }

    public function getMaxDay(): ?int
    {
        return $this->max_day;
    }

    public function setMaxDay(?int $max_day): static
    {
        $this->max_day = $max_day;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discount_rate;
    }

    public function setDiscountRate(?float $discount_rate): static
    {
        $this->discount_rate = $discount_rate;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->addDiscount($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            $property->removeDiscount($this);
        }

        return $this;
    }
}
