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

    protected function collectEmailRecipients(string $expectedRecipients)
    {
        $expectedRecipients = explode(',',preg_replace('/\s+/', '', $expectedRecipients));
        $mailCollector = $this->getMailCollector();
        $this->assertNotEquals(0, $mailCollector->getMessageCount(),"no mail has been sent");
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
        $recipients = array_merge($message->getTo(), $message->getBcc(), $message->getCc());
        $this->assertEqualsCanonicalizing($expectedRecipients,$recipients, "failed to find the expected recipients got ". implode(' ,',$recipients));
    }

    protected function getMailCollector():MessageDataCollector
    {
        return $this->client->getProfile()->getCollector('swiftmailer');
    }
}
