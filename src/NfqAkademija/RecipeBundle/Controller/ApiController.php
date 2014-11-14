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

        return $recipe;
    }

    /**
     * @Get("/recipes")
     */
    public function getRecipesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('RecipeBundle:Recipe')->findAll();
        var_dump($recipes);
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
     * Returns a json encoded array:
     *      [
     *          { "recipe": {
     *                          "id": <id>,
     *                          "name": <name>,
     *                          ...
     *                      },
     *            "koef": <koeficientas>
     *          },
     *          ...
     *      ]
     *
     * @Post("/recipes")
     */
    public function postRecipesAction(Request $request)
    {
        $content = $request->getContent();
        $ingredients = json_decode($content, true);

        $em = $this->getDoctrine()->getManager();
        $ingredientRepo = $em->getRepository('RecipeBundle:Ingredient');
        $recipeRepo     = $em->getRepository('RecipeBundle:Recipe');

        if(!is_array($ingredients)) {
            return $recipeRepo->getOrderedByIngredients(new ArrayCollection());
        }

        $ingredients = array_map(function($i){return $i["name"];},$ingredients);
        $ingredientColl = new ArrayCollection(
            $ingredientRepo->findBy(array('name' => $ingredients))
        );
        $recipes = $recipeRepo->getOrderedByIngredients($ingredientColl);

        return $recipes;
    }

    /**
     * Post user rating.
     * @Post("/rate/recipe")
     */
    public function postRatingAction(Request $request)
    {
        $data = $request->getContent();
        $voteData = json_decode($data, true);

        $id = $voteData['id'];
        $grade = $voteData['rating'];
        $ip = $this->container->get('request')->getClientIp();

        $em = $this->getDoctrine()->getManager();
        $votes = $em->getRepository('RecipeBundle:Votes');

        if($votes->hasUserVoted($voteData['id'], $ip)){
            $error = json_encode(array('message' => 'Jūs už sitą receptą jau balsavote!'));
            return new Response($error, 419);
        }

        // // Record user vote.
        $recipe = $em->getRepository('RecipeBundle:recipe')->find($voteData['id']);
        $votes = new Votes();
        $votes->setRecipe($recipe);
        $votes->setGrade($voteData['rating']);
        $votes->setIp($ip);
        $em->persist($votes);
        $em->flush();

        // Get old average rating
        $recipe = $em->getRepository('RecipeBundle:Recipe')->find($id);
        $recipeRating = $recipe->getRecipeRating();

        // Average rating for that recipe does not exist so let's create one.
        if(!$recipeRating){
            $recipeRating = new RecipeRating();
            $recipeRating->setRecipe($recipe);
            $recipeRating->setAverage($grade);
            $recipeRating->setTotal(1);
            $em->persist($recipeRating);
            $em->flush();

            return;
        }


        // Calculate new average rating.
        $average = $recipeRating->getAverage();
        $total = $recipeRating->getTotal();
        $voteWeight = round($grade / ($total + 1), 2);
        $avgWeight = round(($average / ($total + 1)) * $total, 2);
        $newRating = $voteWeight + $avgWeight;

        // Update rating.
        $recipeRating->setAverage($newRating);
        $recipeRating->setTotal($total + 1);
        $em->flush();
    }

}