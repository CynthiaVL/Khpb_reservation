<?php

namespace App\Entity;

use App\Repository\EmployedPropertyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployedPropertyRepository::class)]
class EmployedProperty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'employedProperties')]
    private ?Employed $employed = null;

    #[ORM\ManyToOne(inversedBy: 'employedProperties')]
    private ?Property $property = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployed(): ?Employed
    {
        return $this->employed;
    }

    public function setEmployed(?Employed $employed): static
    {
        $this->employed = $employed;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

        return $this;
    }
}
