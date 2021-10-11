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

    public function sendMail(User $user, string $subject, string $templatePath, $entityVar = null)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard '))
            ->to(new Address($user->getEmail(), $user->getFirstName()))
            ->subject($subject)
            ->htmlTemplate($templatePath)
            ->context([
                'entityVar'  =>  $entityVar
            ])
        ;

//        "Spill-Coffee-On-The-Keyboard"
//        'email/welcome.html.twig'
        $this->mailer->send($email);
    }
}