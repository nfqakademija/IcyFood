<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredients")
 * @ORM\Entity(repositoryClass="NfqAkademija\RecipeBundle\Entity\IngredientRepository")
 * @ExclusionPolicy("all")
 */
class Ingredient
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
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="NfqAkademija\RecipeBundle\Entity\RecipeIngredient", mappedBy="ingredient")
     *
     **/
    protected $recipes;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->recipes = new ArrayCollection();
    }

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
     * @return Ingredient
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
     * Add recipes
     *
     * @param \NfqAkademija\RecipeBundle\Entity\RecipeIngredient $recipes
     * @return Ingredient
     */
    public function addRecipe(\NfqAkademija\RecipeBundle\Entity\RecipeIngredient $recipes)
    {
        $this->recipes[] = $recipes;

        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \NfqAkademija\RecipeBundle\Entity\RecipeIngredient $recipes
     */
    public function removeRecipe(\NfqAkademija\RecipeBundle\Entity\RecipeIngredient $recipes)
    {
        $this->recipes->removeElement($recipes);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Add children
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Ingredient $children
     * @return Ingredient
     */
    public function addChild(\NfqAkademija\RecipeBundle\Entity\Ingredient $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Ingredient $children
     */
    public function removeChild(\NfqAkademija\RecipeBundle\Entity\Ingredient $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get all children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllChildren()
    {
        $children = $this->children;

        if ($children->isEmpty()) return $children;

        foreach ($this->children as $child) {
            $children = new ArrayCollection(
                array_merge($children->toArray(), $child->getAllChildren()->toArray())
            );
        }

        return $children;
    }

    /**
     * Set parent
     *
     * @param \NfqAkademija\RecipeBundle\Entity\Ingredient $parent
     * @return Ingredient
     */
    public function setParent(\NfqAkademija\RecipeBundle\Entity\Ingredient $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \NfqAkademija\RecipeBundle\Entity\Ingredient 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParents()
    {
        if ($this->getParent() == null) return new ArrayCollection();;

        $parents = $this->parent->getParents();
        $parents[] = $this->parent;

        return $parents;
    }

    /**
     * Get all parents and children
     *
     * @return ArrayCollection
     */
    public function getParentsAndChildren()
    {
        $parents = $this->getParents();
        $children = $this->getAllChildren();

        $collection = new ArrayCollection(
            array_merge($parents->toArray(), $children->toArray())
        );

        return $collection;
    }
}
