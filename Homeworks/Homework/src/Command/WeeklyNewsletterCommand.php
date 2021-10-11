<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeeklyNewsletterCommand extends Command
{
    protected static $defaultName = 'app:weekly-newsletter';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * WeeklyNewsletterCommand constructor.
     */
    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, Mailer $mailer)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->mailer = $mailer;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Еженедельная рассылка новостей')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var User[] $users */
        $users = $this->userRepository->findAllSubscribedUsers();
        $articles = $this->articleRepository->findAllPublishedLastWeek();

        $io = new SymfonyStyle($input, $output);

        if (count($articles) == 0) {
            $io->warning('Никто не публиковал статьи на этой неделе');
            return 0;
        }

        $io->progressStart(count($users));

        foreach ($users as $user) {
            $this->mailer->sendMail(
                $user,
                'Еженедельная рассылка новостей',
                'email/weekly-newsletter.html.twig',
                $articles
            );
            sleep(1);
            $io->progressAdvance();
            break;
        }

        $io->progressFinish();

        return 0;
    }
}
