<?php
namespace EveryCheck\TestApiRestBundle\Tests\sampleProject\src\EmailBundle\Service;

class EmailSender
{
    protected $mailer;
    protected $contactEmail;

    public function __construct(\Swift_Mailer $mailer, $contactEmail)
    {
        $this->mailer = $mailer;
        $this->contactEmail = $contactEmail;
    }

    public function sendEmail(array $to,array $cc = [],array $bcc =[])
    {
        $message = new \Swift_Message("Hello world");
        $message->setFrom($this->contactEmail)
                ->setTo($to)
                ->setCc($cc)
                ->setBcc($bcc)
                ->setBody("Lorem Ipsum");

        $this->mailer->send($message);
    }
}
