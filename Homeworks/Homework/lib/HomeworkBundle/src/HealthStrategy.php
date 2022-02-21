<?php


namespace SymfonySkillbox\HomeworkBundle;


class HealthStrategy
{
    public function next(array $units, int $resource)
    {
        usort($units, function ($a, $b) {
            return ($b->getHealth() - $a->getHealth());
        });

        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource){
                return $unit;
            }
        }

        return false;
    }
}