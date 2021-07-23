<?php


namespace App\Twig;

use App\Service\MarkdownParser;
use Twig\Extension\RuntimeExtensionInterface;


class AppRuntime implements RuntimeExtensionInterface
{

    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    /**
     * AppExtension constructor.
     */
    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
        dd($this);
    }

    public function parseMarkdown($content)
    {
        return $this->markdownParser->parse($content);
    }
}