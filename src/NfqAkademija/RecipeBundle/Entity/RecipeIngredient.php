<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeIngredient
 *
 * @ORM\Table(name="recipes_ingredients")
 * @ORM\Entity
 */
class RecipeIngredient
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
     *
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="ingredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipe;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipes", cascade={"persist"})
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     */
    private $ingredient;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="string", length=255)
     */
    private $quantity;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="ingredients")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unit;


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
     * Set quantity
     *
     * @param string $quantity
     * @return RecipeIngredient
     */
    public function setQuantity($quantity = "")
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set recipe
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Recipe $recipe
     * @return RecipeIngredient
     */
    public function setRecipe(\NfqAkademija\RecipeBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \NfqAkademija\RecipeBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredient
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Ingredient $ingredient
     * @return RecipeIngredient
     */
    public function setIngredient(\NfqAkademija\RecipeBundle\Entity\Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \NfqAkademija\RecipeBundle\Entity\Ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set unit
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Unit $unit
     * @return RecipeIngredient
     */
    public function setUnit(\NfqAkademija\RecipeBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \NfqAkademija\RecipeBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
