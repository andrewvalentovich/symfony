<?php


namespace SymfonySkillbox\HomeworkBundle;


class Unit
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $cost;

    /**
     * @var integer
     */
    private $strength;

    /**
     * @var integer
     */
    private $health;

    public function __construct(string $name, int $cost, int $strength, int $health)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->strength = $strength;
        $this->health = $health;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }
}