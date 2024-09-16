<?php

namespace App\Entity;

use App\Repository\PeriodPriceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodPriceRepository::class)]
class PeriodPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_period = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endPeriod = null;

    #[ORM\Column(nullable: true)]
    private ?float $price_day = null;

    /**
     * @var Collection<int, Property>
     */
    #[ORM\ManyToMany(targetEntity: Property::class, mappedBy: 'period_price')]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartPeriod(): ?\DateTimeInterface
    {
        return $this->start_period;
    }

    public function setStartPeriod(?\DateTimeInterface $start_period): static
    {
        $this->start_period = $start_period;

        return $this;
    }

    public function getEndPeriod(): ?\DateTimeInterface
    {
        return $this->endPeriod;
    }

    public function setEndPeriod(?\DateTimeInterface $endPeriod): static
    {
        $this->endPeriod = $endPeriod;

        return $this;
    }

    public function getPriceDay(): ?float
    {
        return $this->price_day;
    }

    public function setPriceDay(?float $price_day): static
    {
        $this->price_day = $price_day;

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
            $property->addPeriodPrice($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            $property->removePeriodPrice($this);
        }

        return $this;
    }
}
