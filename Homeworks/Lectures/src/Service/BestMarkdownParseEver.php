<?php


namespace App\Service;


use Demontpx\ParsedownBundle\Parsedown;

class BestMarkdownParseEver extends Parsedown
{
    public function text($text)
    {
        return 'Текст';
    }
}