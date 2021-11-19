<?php
namespace EveryCheck\TestApiRestBundle\ControllerTestTrait;

use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;

trait EmailTestTrait
{
    protected function enableMailCatching()
    {
        $this->client->enableProfiler();
    }

    protected function collectEmailAndTestContent($mail,$pcre)
    {
        $mailCollector = $this->getMailCollector();
        $this->assertLessThan($mailCollector->getMessageCount(),$mail,"cannot read mail ". $mail ." only " . $mailCollector->getMessageCount() . "mail sended");
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
        preg_match($pcre, $message->getBody(),$exctractedValue);
        $this->assertGreaterThan(0, count($exctractedValue));
        foreach ($exctractedValue as $key => $value) {
            $this->env['pcre'.$key] = $value;
        }
    }

    protected function assertMailSendedCount($count)
    {
        $mailCollector = $this->getMailCollector();
        $this->assertEquals($count, $mailCollector->getMessageCount(),"failed to expecting $count mails got ". $mailCollector->getMessageCount());
    }

    protected function collectEmailRecipients(array $expectedRecipients)
    {
        $this->checkEmailRecipients($expectedRecipients);
    }

    protected function collectEmailTo(array $expectedTo)
    {
        $this->checkEmailRecipients($expectedTo,true, false, false);
    }

    protected function collectEmailCc(array $expectedCc)
    {
        $this->checkEmailRecipients($expectedCc,false, true, false);
    }

    protected function collectEmailBcc(array $expectedBcc)
    {
        $this->checkEmailRecipients($expectedBcc,false, false, true);
    }

    protected function checkEmailRecipients(array $expectedRecipients, $checkTo = true, $checkCc = true, $checkBcc = true){
        $mailCollector = $this->getMailCollector();
        $this->assertNotEquals(0, $mailCollector->getMessageCount(),"no mail has been sent");
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
        $recipients = [];
        if($checkTo) {
            $recipients = array_merge($recipients, array_keys($message->getTo()));
        }
        if($checkCc) {
            $recipients = array_merge($recipients, array_keys($message->getCc()));
        }
        if($checkBcc) {
            $recipients = array_merge($recipients, array_keys($message->getBcc()));
        }
        $this->assertEqualsCanonicalizing($expectedRecipients,$recipients, "failed to find the expected recipients got ". implode(' ,',$recipients));
    }

    protected function getMailCollector():MessageDataCollector
    {
        return $this->client->getProfile()->getCollector('swiftmailer');
    }
}
