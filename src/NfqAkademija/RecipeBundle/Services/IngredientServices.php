<?php

namespace NfqAkademija\RecipeBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use NfqAkademija\RecipeBundle\Entity\Recipe;
use NfqAkademija\RecipeBundle\Entity\Ingredient;
//use NfqAkademija\RecipeBundle\Entity\RecipeIngredient;

class IngredientServices
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getIngredient($term = null)
    {
        $ingredients = $this->em->createQuery('SELECT i.id, i.name FROM RecipeBundle:Ingredient i WHERE i.name like :searchterm ORDER BY i.id ASC')->setParameter('searchterm', '%'.$term.'%')->getResult();
        return $ingredients;
    }

    public function getRecipes()
    {
        $repository = $this->em->getRepository('RecipeBundle:Recipe');
        $recipes = $repository->findAll();
        foreach ($recipes as $recipe) {
            $uno = [];
            $uno['id'] = $recipe->getId();
            $uno['name'] = $recipe->getName();
            $uno['instructions'] = $recipe->getInstructions();
            $recipe_images = $recipe->getImages();
            $recipe_ingredients = $recipe->getIngredients();
            $ingredient_array = [];
            foreach ($recipe_ingredients as $ingredient) {
                $iuno =[];
                $iuno['name']= $ingredient->getIngredient()->getName();
                $iuno['quantity']= $ingredient->getQuantity();
                $iuno['unit']= $ingredient->getUnit()->getShort();
                $ingredient_array[] = $iuno;
            }
            $uno['ingredients'] = $ingredient_array;
            $images_array = [];
            foreach ($recipe_images as $image) {
                $images_array[]= $image->getWebPath();
            }
            $uno['images'] = $images_array;
            $recipess[] = $uno;
        }
        //var_dump($recipess);die();
        return $recipess;
        //var_dump($recipe); die();
    }
    public function getRecipe($id)
    {
        $repository = $this->em->getRepository('RecipeBundle:Recipe');
        $recipe = $repository->findOneById($id);
        $recipe1['id'] = $recipe->getId();
        $recipe1['name'] = $recipe->getName();
        $recipe1['instructions'] = $recipe->getInstructions();
        $recipe_images = $recipe->getImages();
        $recipe_ingredients = $recipe->getIngredients();
        foreach ($recipe_ingredients as $ingredient) {
            $ingredient_array[]= $ingredient->getIngredient()->getName();
        }
        $recipe1['ingredients'] = $ingredient_array;
        foreach ($recipe_images as $image) {
            $images_array[]= $image->getWebPath();
        }
        $recipe1['images'] = $images_array;
        return $recipe1;
    }

}