<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MailNotificationHandler implements MessageHandlerInterface {

    private $mailer;

    public function __construct (MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function __invoke(MailNotification $message) {
        $email = (new Email())
        ->from($message->getFrom())
        ->to('support@incident.tech')
        ->subject("New Incident #{$message->getId()} - {$message->getFrom()}")
        ->html("<p>{$message->getDescription()}</p>");
        

        // simulate slow process
        sleep(8);

        $this->mailer->send($email);
    }


}