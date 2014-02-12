<?php

namespace H\CocktailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="H\CocktailBundle\Entity\StatRepository")
 */
class Stat
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="approved", type="boolean")
	 */
	private $approved;

	/**
	 * @ORM\OneToOne(targetEntity="H\CocktailBundle\Entity\Color", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $color;

	/**
	 * @ORM\OneToOne(targetEntity="H\CocktailBundle\Entity\Langage", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $langage;

	/**
	 * @ORM\OneToOne(targetEntity="H\CocktailBundle\Entity\Age", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $age;


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set approved
	 *
	 * @param boolean $approved
	 * @return Stat
	 */
	public function setApproved($approved)
	{
		$this->approved = $approved;

		return $this;
	}

	/**
	 * Get approved
	 *
	 * @return boolean
	 */
	public function getApproved()
	{
		return $this->approved;
	}

    /**
     * Set color
     *
     * @param \H\CocktailBundle\Color $color
     * @return Stat
     */
    public function setColor(\H\CocktailBundle\Color $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \H\CocktailBundle\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set langage
     *
     * @param \H\CocktailBundle\Langage $langage
     * @return Stat
     */
    public function setLangage(\H\CocktailBundle\Langage $langage)
    {
        $this->langage = $langage;

        return $this;
    }

    /**
     * Get langage
     *
     * @return \H\CocktailBundle\Langage
     */
    public function getLangage()
    {
        return $this->langage;
    }

    /**
     * Set age
     *
     * @param \H\CocktailBundle\Age $age
     * @return Stat
     */
    public function setAge(\H\CocktailBundle\Age $age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return \H\CocktailBundle\Age
     */
    public function getAge()
    {
        return $this->age;
    }
}
