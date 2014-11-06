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
				$recipess[]['id'] = $recipe->getId();
				$recipess[]['name'] = $recipe->getName();
				$recipess[]['instructions'] = $recipe->getInstructions();
				$recipe_images = $recipe->getImages();
				$recipe_ingredients = $recipe->getIngredients();
				foreach ($recipe_ingredients as $ingredient) {
					$ingredient_array[]= $ingredient->getIngredient()->getName();
				}
				$recipess[]['ingredients'] = $ingredient_array;
				foreach ($recipe_images as $image) {
					$images_array[]= $image->getWebPath();
				}
				$recipess[]['images'] = $images_array;
			}	
		//var_dump($recipess);die();
		return $recipess;
		//var_dump($recipe); die();    
	}
	public function getRecipe($id)
	{
		$repository = $this->em->getRepository('RecipeBundle:Recipe');
		$recipe = $repository->findOneById($id);
				$recipe1[]['id'] = $recipe->getId();
				$recipe1[]['name'] = $recipe->getName();
				$recipe1[]['instructions'] = $recipe->getInstructions();
				$recipe_images = $recipe->getImages();
				$recipe_ingredients = $recipe->getIngredients();
				foreach ($recipe_ingredients as $ingredient) {
					$ingredient_array[]= $ingredient->getIngredient()->getName();
				}
				$recipess[]['ingredients'] = $ingredient_array;
				foreach ($recipe_images as $image) {
					$images_array[]= $image->getWebPath();
				}
				$recipe1[]['images'] = $images_array;
		return $recipe1;    
	}
    
}