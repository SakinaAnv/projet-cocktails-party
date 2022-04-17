<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{

    private $replyTo;
    public function __construct(private MailerInterface $mailer, $replyTo) {
        $this->replyTo = $replyTo;
    }
    public function sendEmail(
        $to = 'mariemesoda88@gmail.com',
        $content = '<p>Nous sommes heureux de vous accueillir sur le site Cocktail Party!<br>Rafraichissez-vous 
        avec les meilleurs sélections de cocktails du moment </p>',
        $subject = 'Bienvenue sur le site Cocktail Party!'
    ): void
    {
        $email = (new Email())
            ->from('mariemesoda88@gmail.com')
            ->to($to)
            ->replyTo($this->replyTo)
            ->subject($subject)
            ->html($content);
        $this->mailer->send($email);

    }
}