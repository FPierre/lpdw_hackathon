<?php

namespace H\CocktailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CocktailIngredient
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="H\CocktailBundle\Entity\CocktailIngredientRepository")
 */
class CocktailIngredient
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
	 * @ORM\Column(name="proportion", type="smallint")
	 */
	private $proportion;

	/**
	 * @ORM\ManyToOne(targetEntity="H\CocktailBundle\Entity\Cocktail", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $cocktail;

	/**
	 * @ORM\ManyToOne(targetEntity="H\CocktailBundle\Entity\Ingredient", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $ingredient;

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
     * Set proportion
     *
     * @param integer $proportion
     * @return CocktailIngredient
     */
    public function setProportion($proportion)
    {
        $this->proportion = $proportion;

        return $this;
    }

    /**
     * Get proportion
     *
     * @return integer
     */
    public function getProportion()
    {
        return $this->proportion;
    }

    /**
     * Set cocktail
     *
     * @param \H\CocktailBundle\Entity\Cocktail $cocktail
     * @return CocktailIngredient
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
     * Set ingredient
     *
     * @param \H\CocktailBundle\Entity\Ingredient $ingredient
     * @return CocktailIngredient
     */
    public function setIngredient(\H\CocktailBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \H\CocktailBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
