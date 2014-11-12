<?php

namespace NfqAkademija\RecipeBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

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
        //TODO: Add user rating.
    }

}