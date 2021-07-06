<?php


namespace App\Service;


use Demontpx\ParsedownBundle\Parsedown;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownParser
{
    /**
     * @var Parsedown
     */
    private $parsedown;
    /**
     * @var AdapterInterface
     */
    private $cache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $debug;

    public function __construct(Parsedown $parsedown, AdapterInterface $cache, LoggerInterface $logger, bool $debug)
    {

        $this->parsedown = $parsedown;
        $this->cache = $cache;
        $this->logger = $logger;
        $this->debug = $debug;
    }

    public function parse(string $source): string
    {
        if(stripos($source, 'красн') !== false){
            $this->logger->info("Красная точка");
        }

        if($this->debug){
            return $this->parsedown->text($source);
        }

        return $this->cache->get('markdown_'. md5($source), function () use ($source){
            return $this->parsedown->text($source);
        });
    }
}