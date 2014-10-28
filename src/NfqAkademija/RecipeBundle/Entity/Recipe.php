<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recipe
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="ingredient_block", type="text")
     */
    private $ingredientBlock;

    /**
     * @var string
     *
     * @ORM\Column(name="instructions_block", type="text")
     */
    private $instructionsBlock;


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
     * Set name
     *
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set ingredientBlock
     *
     * @param string $ingredientBlock
     * @return Recipe
     */
    public function setIngredientBlock($ingredientBlock)
    {
        $this->ingredientBlock = $ingredientBlock;

        return $this;
    }

    /**
     * Get ingredientBlock
     *
     * @return string 
     */
    public function getIngredientBlock()
    {
        return $this->ingredientBlock;
    }

    /**
     * Set instructionsBlock
     *
     * @param string $instructionsBlock
     * @return Recipe
     */
    public function setInstructionsBlock($instructionsBlock)
    {
        $this->instructionsBlock = $instructionsBlock;

        return $this;
    }

    /**
     * Get instructionsBlock
     *
     * @return string 
     */
    public function getInstructionsBlock()
    {
        return $this->instructionsBlock;
    }
}
