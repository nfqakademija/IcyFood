<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AverageRating
 *
 * @ORM\Table(name="average_rating")
 * @ORM\Entity
 */
class AverageRating
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
     * @ORM\OneToOne(targetEntity="Recipe", inversedBy="averageRating")
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
     * @ORM\Column(name="total_votes", type="integer")
     */
    private $totalVotes;


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
     * @return AverageRating
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
     * Set totalVotes
     *
     * @param integer $totalVotes
     * @return AverageRating
     */
    public function setTotalVotes($totalVotes)
    {
        $this->totalVotes = $totalVotes;

        return $this;
    }

    /**
     * Get totalVotes
     *
     * @return integer 
     */
    public function getTotalVotes()
    {
        return $this->totalVotes;
    }

    /**
     * Set recipe
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Recipe $recipe
     * @return AverageRating
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
