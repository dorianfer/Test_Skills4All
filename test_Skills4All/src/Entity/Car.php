<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSeats;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDoors;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cost;

    /**
     * @ORM\OneToMany(targetEntity=CarCategory::class, mappedBy="carId")
     */
    private $carCategories;

    public function __construct()
    {
        $this->carCategories = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbSeats(): ?int
    {
        return $this->nbSeats;
    }

    public function setNbSeats(int $nbSeats): self
    {
        $this->nbSeats = $nbSeats;

        return $this;
    }

    public function getNbDoors(): ?int
    {
        return $this->nbDoors;
    }

    public function setNbDoors(int $nbDoors): self
    {
        $this->nbDoors = $nbDoors;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return Collection<int, CarCategory>
     */
    public function getCarCategories(): Collection
    {
        return $this->carCategories;
    }

    public function addCarCategory(CarCategory $carCategory): self
    {
        if (!$this->carCategories->contains($carCategory)) {
            $this->carCategories[] = $carCategory;
            $carCategory->setCarId($this);
        }

        return $this;
    }

    public function removeCarCategory(CarCategory $carCategory): self
    {
        if ($this->carCategories->removeElement($carCategory)) {
            // set the owning side to null (unless already changed)
            if ($carCategory->getCar()->getId() === $this) {
                $carCategory->setCarId(null);
            }
        }

        return $this;
    }
}
