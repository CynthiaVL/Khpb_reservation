<?php

namespace App\Entity;

use App\Repository\EmployedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployedRepository::class)]
class Employed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'employed', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, EmployedProperty>
     */
    #[ORM\OneToMany(targetEntity: EmployedProperty::class, mappedBy: 'employed')]
    private Collection $employedProperties;

    public function __construct()
    {
        $this->employedProperties = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

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
            $employedProperty->setEmployed($this);
        }

        return $this;
    }

    public function removeEmployedProperty(EmployedProperty $employedProperty): static
    {
        if ($this->employedProperties->removeElement($employedProperty)) {
            // set the owning side to null (unless already changed)
            if ($employedProperty->getEmployed() === $this) {
                $employedProperty->setEmployed(null);
            }
        }

        return $this;
    }
}
