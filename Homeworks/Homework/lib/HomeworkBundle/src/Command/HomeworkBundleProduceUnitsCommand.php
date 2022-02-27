<?php

namespace SymfonySkillbox\HomeworkBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use SymfonySkillbox\HomeworkBundle\StrategyInterface;
use SymfonySkillbox\HomeworkBundle\StrengthStrategy;
use SymfonySkillbox\HomeworkBundle\UnitFactory;


class HomeworkBundleProduceUnitsCommand extends Command
{
//    protected static $defaultName = 'homework-bundle:produce-units';
//    protected static $defaultDescription = 'Производство юнитов';


    protected function configure(): void
    {
        $this
            ->addArgument(
                'resources',
                InputArgument::REQUIRED,
                'Resources for producing'
            )
            ->addOption(
                'strategy',
                null,
                InputOption::VALUE_NONE, 'Producing strategy'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $resources = (int)$input->getArgument('resources');

        if ($resources) {
            $io->note(sprintf('You passed an argument: %s', $resources));
            $army = $this->factory->produceUnits($resources);
        }

        foreach ($army as $arm) {
            $io->note(var_dump($arm));
        }
//        if ($input->getOption('strategy')) {
//            // ...
//        }

        $table = new Table($output);
        $table
            ->setHeaders(['Имя', 'Цена', 'Сила', 'Здоровье'])
        ;

        $table->setStyle('borderless');
        $table->render();

        $io->success('Strategy completed');

        return Command::SUCCESS;
    }
}
