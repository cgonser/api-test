<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

/**
 * @Entity
 * @Cache(usage="NONSTRICT_READ_WRITE")
 * @Table(name="recipe")
 **/
class Recipe implements \JsonSerializable
{
    /**
     * @Id
     * @Column(type="uuid", unique=true)
     *
     * @var UuidInterface
     */
    private $id;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @Column(type="integer", name="prep_time")
     *
     * @var integer
     */
    private $prepTime;

    /**
     * @Column(type="integer")
     *
     * @var integer
     */
    private $difficulty;

    /**
     * @Column(type="boolean")
     *
     * @var boolean
     */
    private $vegetarian;

    /**
     * @Column(type="datetime", name="created_at")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Column(type="datetime", name="updated_at")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @Column(type="float", name="rate_average", nullable=true)
     *
     * @var float
     */
    private $rateAverage;

    /**
     * @OneToMany(targetEntity="RecipeRate", mappedBy="recipe", cascade={"persist"})
     *
     * @var ArrayCollection
     */
    private $recipeRates;

    public function __construct()
    {
        $this->recipeRates = new ArrayCollection();
    }

    public static function createWithValues(UuidInterface $id, string $name, int $prepTime, int $difficulty, bool $vegetarian): Recipe
    {
        $recipe = new self();
        $recipe->id = $id;
        $recipe->name = $name;
        $recipe->prepTime = $prepTime;
        $recipe->difficulty = $difficulty;
        $recipe->vegetarian = $vegetarian;
        $recipe->createdAt = new \DateTime();
        $recipe->updatedAt = new \DateTime();

        return $recipe;
    }

    public function update(string $name, int $prepTime, int $difficulty, bool $vegetarian)
    {
        $this->name = $name;
        $this->prepTime = $prepTime;
        $this->difficulty = $difficulty;
        $this->vegetarian = $vegetarian;
        $this->updatedAt = new \DateTime();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrepTime(): int
    {
        return $this->prepTime;
    }

    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    public function isVegetarian(): bool
    {
        return $this->vegetarian;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function getRateAverage(): ?float
    {
        return $this->rateAverage;
    }

    public function getRecipeRates(): ArrayCollection
    {
        return $this->recipeRates;
    }

    public function addRate(RecipeRate $recipeRate)
    {
        $this->recipeRates->add($recipeRate);

        $this->updateRateAverage();
    }

    protected function updateRateAverage()
    {
        if ($this->recipeRates->count() == 0) {
            $this->rateAverage = 0;
            return;
        }

        $totalRate = array_reduce($this->recipeRates->toArray(), function ($totalRate, $recipeRate) {
            return $totalRate + (int) $recipeRate->getRate();
        });

        $this->rateAverage = round($totalRate / $this->recipeRates->count());
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'prep_time' => $this->prepTime,
            'difficulty' => $this->difficulty,
            'vegetarian' => $this->vegetarian,
            'rate_average' => $this->rateAverage,
            'created_at' => $this->createdAt ? $this->createdAt->format(DATE_ISO8601) : null,
            'updated_at' => $this->updatedAt ? $this->updatedAt->format(DATE_ISO8601) : null,
        ];
    }
}
