<?php

namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

/**
 * @Entity
 * @Cache(usage="NONSTRICT_READ_WRITE")
 * @Table(name="recipe_rate")
 **/
class RecipeRate
{
    /**
     * @Id
     * @Column(type="uuid", unique=true)
     *
     * @var UuidInterface
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Recipe", inversedBy="recipeRates")
     * @JoinColumn(name="recipe_id", referencedColumnName="id")
     *
     * @var UuidInterface
     */
    private $recipe;

    /**
     * @Column(type="integer")
     *
     * @var integer
     */
    private $rate;

    /**
     * @Column(type="datetime", name="created_at")
     *
     * @var \DateTime
     */
    private $createdAt;

    public static function createWithValues(UuidInterface $id, Recipe $recipe, int $rate): RecipeRate
    {
        $recipeRate = new self();
        $recipeRate->id = $id;
        $recipeRate->recipe = $recipe;
        $recipeRate->rate = $rate;
        $recipeRate->createdAt = new \DateTime();

        return $recipeRate;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRate(): string
    {
        return $this->rate;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
