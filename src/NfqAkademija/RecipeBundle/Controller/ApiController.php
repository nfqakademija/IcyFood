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
        $ingredients = json_decode($content);
        $em = $this->getDoctrine()->getManager();
        $ingredientColl = new ArrayCollection(
            $em->getRepository('RecipeBundle:Ingredient')->findBy(array('name' => $ingredients))
        );
        $recipes = $em->getRepository('RecipeBundle:Recipe')->getOrderedByIngredients($ingredientColl);

        return $recipes;
    }

}