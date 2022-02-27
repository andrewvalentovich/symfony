<?php


namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('symfony_skillbox_homework_bundle');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->booleanNode('enable_solder')->defaultTrue()->end()
            ->booleanNode('enable_archer')->defaultTrue()->end()
            ->scalarNode('strategy')->defaultValue('SymfonySkillbox\HomeworkBundle\StrengthStrategy')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}