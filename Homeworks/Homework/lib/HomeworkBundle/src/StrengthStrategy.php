<?php


namespace SymfonySkillbox\HomeworkBundle;


/**
 * Class StrengthStrategy
 * @package SymfonySkillbox\HomeworkBundle
 */
class StrengthStrategy implements StrategyInterface
{
    public function next(array $units, int $resource)
    {
        usort($units, function ($a, $b) {
            return ($b->getStrength() - $a->getStrength());
        });

        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource){
                return $unit;
            }
        }

        return false;
    }
}