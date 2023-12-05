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

    /**
     * @var ArrayCollection<int, EatenMeal>
     */
    #[ORM\OneToMany(mappedBy: 'meal', targetEntity: EatenMeal::class, orphanRemoval: true)]
    private Collection $eatenMeal;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFilename = null;

    public function __construct()
    {
        $this->eatenMeal = new ArrayCollection();
        $this->setPublic(false);
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
     * @return Collection<int, EatenMeal>
     */
    public function getEatenMeal(): Collection
    {
        return $this->eatenMeal;
    }

    public function addEatenMeal(EatenMeal $eatenMeal): static
    {
        if (!$this->eatenMeal->contains($eatenMeal)) {
            $this->eatenMeal->add($eatenMeal);
            $eatenMeal->setMeal($this);
        }

        return $this;
    }

    public function removeEatenMeal(EatenMeal $eatenMeal): static
    {
        if ($this->eatenMeal->removeElement($eatenMeal)) {
            // set the owning side to null (unless already changed)
            if ($eatenMeal->getMeal() === $this) {
                $eatenMeal->setMeal(null);
            }
        }

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): static
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }
}
