<?php

namespace NfqAkademija\RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomePageController extends Controller
{
	/** 
	* @Route("/", name="recipe_homepage")
	* @Template("RecipeBundle:HomePage:index.html.twig")
	*/
    public function indexAction()
    {
        return array();
    }
    /**                                                                                   
 	* @Route("/search", name="search_ingredient")
 	*/
	public function ajaxAction(Request $request)    
	{
    	//if ($request->isXMLHttpRequest()) {    

        	$ingredient = $this->container->get('recipe.home');
        	$term = $request->query->get('q');
        	return new JsonResponse($ingredient->getIngredient($term));
    	//}
        //return new Response('error');
	}
     /**                                                                                   
    * @Route("/recipe", name="search_recipe")
    */
    public function getRecipeAction(Request $request)    
    {    
            $recipe = $this->get('recipe.home');
            return new JsonResponse($recipe->getRecipes());

    }
    /**
     * @Route("/show/{id}", name="show_recipe")
     * @Template("RecipeBundle:HomePage:recipe.html.twig")
     */
    public function showAction($id)
    {
        $recipe = $this->get('recipe.home');
        //return array('recipe' => $recipe->getRecipe($id));
        return new JsonResponse($recipe->getRecipe($id));
    }
    /**
     * @Route("/tag", name="tag")
     * @Template("RecipeBundle:HomePage:tag.html.twig")
     */
    public function tagAction()
    {
        return array();
    }
}
