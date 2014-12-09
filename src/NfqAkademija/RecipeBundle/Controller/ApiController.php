<?php

namespace NfqAkademija\RecipeBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use NfqAkademija\RecipeBundle\Entity\Votes;
use NfqAkademija\RecipeBundle\Entity\RecipeRating;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @Get("/recipe/{id}")
     */
    public function getRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('RecipeBundle:Recipe')->find($id);
        if(!is_object($recipe)){
            throw $this->createNotFoundException();
        }

        $ratingService = $this->container->get('recipe.rating');
        $recipe = $ratingService->addRatingByIp($this->container->get('request')->getClientIp(), ['recipe' => $recipe]);

        return $recipe;
    }

    /**
     * @Get("/recipes")
     */
    public function getRecipesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('RecipeBundle:Recipe')->findAll();

        return $recipes;
    }

    /**
     * Returns filtered ingredient list
     *
     * @Get("/ingredients/filter/{term}")
     */
    public function getIngredientsFilterAction($term)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredients = $em->getRepository('RecipeBundle:Ingredient')->getFiltered($term);

        return $ingredients;
    }

    /**
     * Takes post data as ["Kiaušiniai", "Aliejus"]
     * @Post("/recipes")
     */
    public function postRecipesAction(Request $request)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);
        $ingredients = $json["ingredients"];

        $em = $this->getDoctrine()->getManager();
        $ingredientRepo = $em->getRepository('RecipeBundle:Ingredient');
        $recipeService = $this->container->get('recipe.service');

        $ingredients = array_map(function($i){return $i["id"];},$ingredients);
        $ingredientColl = new ArrayCollection(
            $ingredientRepo->findBy(array('id' => $ingredients))
        );
        $recipes = $recipeService->getRecipesByIngredients($ingredientColl, $json["offset"], $json["limit"]);
        $ratingService = $this->container->get('recipe.rating');
        $recipes = $ratingService->addRatingByIpAll($this->container->get('request')->getClientIp(), $recipes);

        return $recipes;
    }

    /**
     * Post user rating.
     * @Post("/rate/recipe")
     */
    public function postRatingAction(Request $request)
    {
        $this->get('recipe.rating')->postRatingAction($request->getContent());
        return;
        // $data = $request->getContent();
        // $voteData = json_decode($data, true);

        // $id = $voteData['id'];
        // $grade = $voteData['rating'];
        // $ip = $this->container->get('request')->getClientIp();

        // $em = $this->getDoctrine()->getManager();
        // $votes = $em->getRepository('RecipeBundle:Votes');

        // if($votes->hasUserVoted($voteData['id'], $ip)){
        //     return false;
        // }

        // // Record user vote.
        // $recipe = $em->getRepository('RecipeBundle:recipe')->find($voteData['id']);
        // $votes = new Votes();
        // $votes->setRecipe($recipe);
        // $votes->setGrade($voteData['rating']);
        // $votes->setIp($ip);
        // $em->persist($votes);
        // $em->flush();

        // // Get old average rating
        // $recipe = $em->getRepository('RecipeBundle:Recipe')->find($id);
        // $recipeRating = $recipe->getRecipeRating();

        // // Average rating for that recipe does not exist so let's create one.
        // if(!$recipeRating){
        //     $recipeRating = new RecipeRating();
        //     $recipeRating->setRecipe($recipe);
        //     $recipeRating->setAverage($grade);
        //     $recipeRating->setTotal(1);
        //     $em->persist($recipeRating);
        //     $em->flush();

        //     return;
        // }

        // // Calculate new average rating.
        // $average = $recipeRating->getAverage();
        // $total = $recipeRating->getTotal();
        // $voteWeight = round($grade / ($total + 1), 2);
        // $avgWeight = round(($average / ($total + 1)) * $total, 2);
        // $newRating = $voteWeight + $avgWeight;

        // // Update rating.
        // $recipeRating->setAverage($newRating);
        // $recipeRating->setTotal($total + 1);
        // $em->flush();
    }

}