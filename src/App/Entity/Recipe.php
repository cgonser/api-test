<?php

namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

class Recipe implements \JsonSerializable
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $prepTime;

    /**
     * @var integer
     */
    private $difficulty;

    /**
     * @var boolean
     */
    private $vegetarian;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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

    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'prep_time' => $this->prepTime,
            'difficulty' => $this->difficulty,
            'vegetarian' => $this->vegetarian,
            'created_at' => $this->createdAt->format(DATE_ISO8601),
            'updated_at' => $this->updatedAt->format(DATE_ISO8601),
        ];
    }
}
