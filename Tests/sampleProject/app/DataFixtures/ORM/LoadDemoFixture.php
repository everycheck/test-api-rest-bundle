<?php

namespace EveryCheck\TestApiRestBundle\Tests\sampleProject\app\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use EveryCheck\TestApiRestBundle\Tests\sampleProject\src\DemoBundle\Entity\Demo;

class LoadDemoFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $demo1 = new Demo();
        $demo1->setName("foo");
        $demo1->setValue(300);
		$demo1->setValue2("an exclude value not tested with DB action");
		$demo1->setValue3("an exclude value tested with DB action");
        $manager->persist($demo1);

        $demo2= new Demo();
        $demo2->setName("the answer");
        $demo2->setValue(42);
		$demo2->setValue2("an exclude value not tested with DB action");
		$demo2->setValue3("an exclude value tested with DB action");
        $manager->persist($demo2);

        $manager->flush();
    }
}