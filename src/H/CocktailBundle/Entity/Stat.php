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
     * @var integer
     *
     * @ORM\Column(name="approved", type="integer")
     */
    private $approved;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @ORM\OneToOne(targetEntity="H\CocktailBundle\Entity\Cocktail", cascade={"persist"})
     */
    private $cocktail;

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
     * @param integer $approved
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
     * @return integer 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Stat
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set cocktail
     *
     * @param \H\CocktailBundle\Entity\Cocktail $cocktail
     * @return Stat
     */
    public function setCocktail(\H\CocktailBundle\Entity\Cocktail $cocktail)
    {
        $this->cocktail = $cocktail;

        return $this;
    }

    /**
     * Get cocktail
     *
     * @return \H\CocktailBundle\Entity\Cocktail 
     */
    public function getCocktail()
    {
        return $this->cocktail;
    }

    /**
     * Set color
     *
     * @param \H\CocktailBundle\Entity\Color $color
     * @return Stat
     */
    public function setColor(\H\CocktailBundle\Entity\Color $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \H\CocktailBundle\Entity\Color 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set langage
     *
     * @param \H\CocktailBundle\Entity\Langage $langage
     * @return Stat
     */
    public function setLangage(\H\CocktailBundle\Entity\Langage $langage)
    {
        $this->langage = $langage;

        return $this;
    }

    /**
     * Get langage
     *
     * @return \H\CocktailBundle\Entity\Langage 
     */
    public function getLangage()
    {
        return $this->langage;
    }

    /**
     * Set age
     *
     * @param \H\CocktailBundle\Entity\Age $age
     * @return Stat
     */
    public function setAge(\H\CocktailBundle\Entity\Age $age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return \H\CocktailBundle\Entity\Age 
     */
    public function getAge()
    {
        return $this->age;
    }
}
