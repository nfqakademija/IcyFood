<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeRating
 *
 * @ORM\Table(name="recipe_rating")
 * @ORM\Entity
 */
class RecipeRating
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
     * @ORM\OneToOne(targetEntity="Recipe", inversedBy="recipeRating")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipe;

    /**
     * @var float
     *
     * @ORM\Column(name="average", type="float")
     */
    private $average;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;


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
     * Set average
     *
     * @param float $average
     * @return RecipeRating
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return float 
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return RecipeRating
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set recipe
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Recipe $recipe
     * @return RecipeRating
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
}
