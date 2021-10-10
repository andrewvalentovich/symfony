<?php


namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard '))
            ->to(new Address($user->getEmail(), $user->getFirstName()))
            ->subject("Spill-Coffee-On-The-Keyboard")
            ->htmlTemplate('email/welcome.html.twig')
            ->context([
                'user'  =>  $user
            ])
        ;

        $this->mailer->send($email);
    }
}