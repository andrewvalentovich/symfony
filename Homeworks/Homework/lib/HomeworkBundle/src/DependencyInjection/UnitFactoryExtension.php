<?php

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class UnitFactoryExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config =$this->processConfiguration($configuration, $configs);
        $definition = $container->getDefinition('symfony_skillbox.produce_unit_command');
        $definition->setArgument(null, $configs[0]['strategy']);
        $definition->setArgument(0, $configs[0]['enable_solder']);
        $definition->setArgument(0, $configs[0]['enable_archer']);

//        if (null !== $config['strategy']) {
//            $container->setAlias('symfony_skillbox_homework.strategy_strength', $config['strategy']);
//        }
    }

    public function getAlias()
    {
        return 'symfony_skillbox_homework_bundle';
    }


}