<?php

namespace EveryCheck\TestApiRestBundle\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ForeignKeyEnabler implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $em, string $databaseUrl)
    {
        $this->em = $em;
        $this->databaseUrl = $databaseUrl;
    }

    public static function getSubscribedEvents()
    {
        return [ 'preFlush' ];
    }

    public function preFlush(PreFlushEventArgs $args)
    {
        if(substr($this->databaseUrl,0,10) != 'sqlite:///')
        {
            return;
        }

        $this->em
            ->createNativeQuery('PRAGMA foreign_keys = ON;', new ResultSetMapping())
            ->execute();
    }
}