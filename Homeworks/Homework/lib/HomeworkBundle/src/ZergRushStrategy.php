<?php


namespace SymfonySkillbox\HomeworkBundle;


class ZergRushStrategy
{
    public function next(array $units, int $resource)
    {
        usort($units, function ($a, $b) {
            return ($a->getCost() - $b->getCost());
        });

        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource){
                return $unit;
            }
        }

        return false;
    }
}