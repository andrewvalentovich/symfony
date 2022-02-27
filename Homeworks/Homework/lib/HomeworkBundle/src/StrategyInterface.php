<?php

namespace SymfonySkillbox\HomeworkBundle;

interface StrategyInterface
{
    /**
     * @param Unit[] $units
     * @param int $resource
     */

    public function next(array $units, int $resource);
}
