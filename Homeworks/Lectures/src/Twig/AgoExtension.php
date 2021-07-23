<?php

namespace App\Twig;

use Carbon\Carbon;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AgoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [$this, 'gedDiff']),
        ];
    }

    public function gedDiff($value)
    {
        return Carbon::make($value)->locale('ru')->diffForHumans();
    }
}
