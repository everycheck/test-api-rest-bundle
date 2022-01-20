<?php

namespace EveryCheck\TestApiRestBundle\Tests\sampleProject\src\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Demo
 *
 * @ORM\Table(name="demo")
 * @ORM\Entity()
 */
class Demo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="value2", type="string", length=255)
	 * @JMS\Groups({"a_random_group"})
	 */
	private $value2;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="value3", type="string", length=255)
	 * @JMS\Groups({"unit_testing"})
	 */
	private $value3;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Demo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return Demo
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

	/**
	 * @return string
	 */
	public function getValue2()
	{
		return $this->value2;
	}

	/**
	 * @param string $value2
	 */
	public function setValue2($value2)
	{
		$this->value2 = $value2;
	}

	/**
	 * @return string
	 */
	public function getValue3()
	{
		return $this->value3;
	}

	/**
	 * @param string $value3
	 */
	public function setValue3($value3)
	{
		$this->value3 = $value3;
	}
}
