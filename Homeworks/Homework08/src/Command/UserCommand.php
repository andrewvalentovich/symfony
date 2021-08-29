<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserCommand extends Command
{
    protected static $defaultName = 'app:user:deactivate';
    protected static $defaultDescription = 'Deactivate user with its id';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserCommand constructor.
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'User`s id')
            ->addOption('reverse', null, InputOption::VALUE_OPTIONAL, 'Activate user', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user_id = $input->getArgument('id');
        $reverse = $input->getOption('reverse');

        $user = $this->userRepository->findOneBy(['id' => $user_id]);

        if (false === $reverse) {           // Если не установлена опция --reverse (деактивируем пользователя)
            if (! $user->getIsActive()) {   // Если пользователь не активен, выводим ошибку
                $io->error(sprintf('User with id = %d is deactive', $user_id));
            } else {
                $this->entityManagerDatabaseVerdictSet(false, $user);

                $io->success(sprintf('User with id = %d has been successly deactivated', $user_id));
            }
        } else {                            // (активируем пользователя)
            if ($user->getIsActive()) {     // Если пользователь активен, выводим ошибку, иначе активируем
                $io->error(sprintf('User with id = %d is active', $user_id));
            } else {
                $this->entityManagerDatabaseVerdictSet(true, $user);

                $io->success(sprintf('User with id = %d has been successly activated', $user_id));
            }
        }

        return Command::SUCCESS;
    }

    private function entityManagerDatabaseVerdictSet(bool $verdict, User $user)
    {
        $user->setIsActive($verdict);
        $this->em->persist($user);
        $this->em->flush();
    }
}
