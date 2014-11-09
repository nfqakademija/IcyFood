<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Recipe
 *
 * @ORM\Table(name="recipes")
 * @ORM\Entity(repositoryClass="NfqAkademija\RecipeBundle\Entity\RecipeRepository")
 * @ExclusionPolicy("all")
 */
class Recipe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="recipe", cascade={"all"})
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="instructions", type="text")
     * @Expose
     */
    private $instructions;

    /**
     * @ORM\OneToMany(targetEntity="NfqAkademija\RecipeBundle\Entity\RecipeIngredient", mappedBy="recipe", cascade={"all"})
     * @Accessor(getter="getIngredientsNormalized")
     * @Type("array")
     * @Expose
     */
    protected $ingredients;

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
     * Set instructions
     *
     * @param string $instructions
     * @return Recipe
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get instructions
     *
     * @return string 
     */
    public function getInstructions()
    {
        return $this->instructions;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingredients
     *
     * @param \NfqAkademija\RecipeBundle\Entity\RecipeIngredient $ingredients
     * @return Recipe
     */
    public function addIngredient(\NfqAkademija\RecipeBundle\Entity\RecipeIngredient $ingredients)
    {
        $ingredients->setRecipe($this);
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \NfqAkademija\RecipeBundle\Entity\RecipeIngredient $ingredients
     */
    public function removeIngredient(\NfqAkademija\RecipeBundle\Entity\RecipeIngredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Get normalized ingredients
     *
     * @return array
     */
    public function getIngredientsNormalized()
    {
        $array = [];
        foreach ($this->ingredients as $item) {
            $ingredient = [];
            $ingredient['name'] = $item->getIngredient()->getName();
            $ingredient['quantity'] = $item->getQuantity();
            $ingredient['unit'] = $item->getUnit()->getShort();
            $array[] = $ingredient;
        }

        return $array;
    }

    /**
     * Add images
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Image $images
     * @return Recipe
     */
    public function addImage(\NfqAkademija\RecipeBundle\Entity\Image $images)
    {
        $images->setRecipe($this);

        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Image $images
     */
    public function removeImage(\NfqAkademija\RecipeBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get image main
     *
     * @VirtualProperty
     * @SerializedName("image")
     * @Type("string")
     *
     * @return string
     */
    public function getImageMain()
    {
        return $this->images[0]->getWebPath();
    }
}
