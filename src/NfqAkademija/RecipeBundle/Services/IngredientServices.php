<?php

namespace NfqAkademija\RecipeBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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

	public function getRecipe()
	{
		$repository = $this->em->getRepository('RecipeBundle:Recipe');
		$recipes = $repository->findAll();
		foreach ($recipes as $recipe) {
				$recipess[] = array('id'=>$recipe->getId(),'name'=>$recipe->getName());
			}	
		return $recipess;
		//var_dump($recipe); die();    
	}
    
}