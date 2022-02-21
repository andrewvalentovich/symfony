<?php


namespace SymfonySkillbox\HomeworkBundle;


class BillGatesStrategy
{
    public function next(array $units, int $resource)
    {
        usort($units, function ($a, $b) {
            return ($b->getCost() - $a->getCost());
        });

        foreach ($units as $unit) {
            if ($unit->getCost() <= $resource){
                return $unit;
            }
        }

        return false;
    }
}