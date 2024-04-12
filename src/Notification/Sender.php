<?php

namespace App\Notification;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{
    protected MailerInterface $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewUserNotificationToAdmin(UserInterface $user) : void
    {
        //file_put_contents('debug.txt', $user->getEmail() . ' has been registered');
        $message = new Email();
        $message->from('acounts@series.com') // l'adresse mail de l'expéditeur
            ->to('admin@series.com') // l'adresse mail du destinataire
            ->subject('New account created on series.com!')
            ->html('<h1>New account has been created on series.com with the email :</h1>' . $user->getEmail());

        $this->mailer->send($message);
    }

}