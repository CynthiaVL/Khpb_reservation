<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: false)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $meter = null;

    #[ORM\Column(nullable: true)]
    private ?array $planning = null;

    #[ORM\Column]
    private ?int $max_guest = null;

    #[ORM\Column]
    private ?bool $online = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'property', cascade:['persist', 'remove'])]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'properties', cascade: ['persist'])]
    private ?Address $address = null;

    /**
     * @var Collection<int, Discount>
     */
    #[ORM\ManyToMany(targetEntity: Discount::class, inversedBy: 'properties', cascade:['persist', 'remove'])]
    private Collection $discount;

    /**
     * @var Collection<int, PeriodPrice>
     */
    #[ORM\ManyToMany(targetEntity: PeriodPrice::class, inversedBy: 'properties', cascade:['persist', 'remove'])]
    private Collection $period_price;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToOne(mappedBy: 'property', cascade: ['persist', 'remove'])]
    private ?Owner $owner = null;

    /**
     * @var Collection<int, EmployedProperty>
     */
    #[ORM\OneToMany(targetEntity: EmployedProperty::class, mappedBy: 'property')]
    private Collection $employedProperties;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'property')]
    private Collection $reservations;

    #[ORM\Column]
    private ?int $min_day = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_day = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->discount = new ArrayCollection();
        $this->period_price = new ArrayCollection();
        $this->employedProperties = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->created_at = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMeter(): ?float
    {
        return $this->meter;
    }

    public function setMeter(float $meter): static
    {
        $this->meter = $meter;

        return $this;
    }

    public function getPlanning(): ?array
    {
        return $this->planning;
    }

    public function setPlanning(?array $planning): static
    {
        $this->planning = $planning;

        return $this;
    }

    public function getMaxGuest(): ?int
    {
        return $this->max_guest;
    }

    public function setMaxGuest(int $max_guest): static
    {
        $this->max_guest = $max_guest;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): static
    {
        $this->online = $online;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProperty($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProperty() === $this) {
                $image->setProperty(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Discount>
     */
    public function getDiscount(): Collection
    {
        return $this->discount;
    }

    public function addDiscount(Discount $discount): static
    {
        if (!$this->discount->contains($discount)) {
            $this->discount->add($discount);
        }

        return $this;
    }

    public function removeDiscount(Discount $discount): static
    {
        $this->discount->removeElement($discount);

        return $this;
    }

        /**
     * @return Collection<int, PeriodPrice>
     */
    public function getPeriodPrice(): Collection
    {
        return $this->period_price;
    }

    public function addPeriodPrice(PeriodPrice $period_price): static
    {
        if (!$this->period_price->contains($period_price)) {
            $this->period_price->add($period_price);
        }

        return $this;
    }

    public function removePeriodPrice(PeriodPrice $period_price): static
    {
        $this->period_price->removeElement($period_price);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): static
    {
        // set the owning side of the relation if necessary
        if ($owner->getProperty() !== $this) {
            $owner->setProperty($this);
        }

        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, EmployedProperty>
     */
    public function getEmployedProperties(): Collection
    {
        return $this->employedProperties;
    }

    public function addEmployedProperty(EmployedProperty $employedProperty): static
    {
        if (!$this->employedProperties->contains($employedProperty)) {
            $this->employedProperties->add($employedProperty);
            $employedProperty->setProperty($this);
        }

        return $this;
    }

    public function removeEmployedProperty(EmployedProperty $employedProperty): static
    {
        if ($this->employedProperties->removeElement($employedProperty)) {
            // set the owning side to null (unless already changed)
            if ($employedProperty->getProperty() === $this) {
                $employedProperty->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setProperty($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getProperty() === $this) {
                $reservation->setProperty(null);
            }
        }

        return $this;
    }

    public function getMinDay(): ?int
    {
        return $this->min_day;
    }

    public function setMinDay(int $min_day): static
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
}
