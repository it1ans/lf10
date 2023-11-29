<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $calories = null;

    #[ORM\Column]
    private ?bool $public = null;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'meal', targetEntity: EatenMeals::class)]
    private Collection $eatenMeals;

    public function __construct()
    {
        $this->eatenMeals = new ArrayCollection();
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

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): static
    {
        $this->calories = $calories;

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, EatenMeals>
     */
    public function getEatenMeals(): Collection
    {
        return $this->eatenMeals;
    }

    public function addEatenMeal(EatenMeals $eatenMeal): static
    {
        if (!$this->eatenMeals->contains($eatenMeal)) {
            $this->eatenMeals->add($eatenMeal);
            $eatenMeal->setMeal($this);
        }

        return $this;
    }

    public function removeEatenMeal(EatenMeals $eatenMeal): static
    {
        if ($this->eatenMeals->removeElement($eatenMeal)) {
            // set the owning side to null (unless already changed)
            if ($eatenMeal->getMeal() === $this) {
                $eatenMeal->setMeal(null);
            }
        }

        return $this;
    }
}
