<?php

namespace NfqAkademija\RecipeBundle\Controller;

use NfqAkademija\RecipeBundle\Entity\Recipe;
use NfqAkademija\RecipeBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddRecipeController extends Controller
{
    /**
     * @Route("/naujas", name="new_recipe")
     * @Template()
     */
    public function newAction()
    {
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType(), $recipe, array(
            'action' => $this->generateUrl('new_recipe_submit'),
        ));

        return $this->render(
            'RecipeBundle:AddRecipe:new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/naujas/submit", name="new_recipe_submit")
     * @Template()
     */
    public function submitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RecipeType(), new Recipe());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $recipe = $form->getData();
            $recipesingredients = $recipe->getIngredients();
            foreach($recipesingredients as $recipeingredient){
                $oldIngredient = $em->getRepository('RecipeBundle:Ingredient')->findOneBy([
                    'name' => $recipeingredient->getIngredient()->getName()
                ]);

                if($oldIngredient){
                    $recipe->removeIngredient($recipeingredient);
                    $recipeingredient->setIngredient($oldIngredient);
                    $recipe->addIngredient($recipeingredient);
                }
            }

            $em->persist($recipe);
            $em->flush();

            return $this->redirect($this->generateUrl('recipe_homepage'));
        }

        return $this->render(
            'RecipeBundle:AddRecipe:new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/test", name="test")
     * @Template()
     */
    public function testAction()
    {
        $ingredients = ['Kiaušiniai', 'Svogūnai'];
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('RecipeBundle:Recipe')->getOrderedByIngredients($ingredients);
        $result = "";
        foreach($recipes as $recipe){
            $result .= $recipe[0]->getName()." ".$recipe['koef']."<br />";
        }
        return new Response($result);
    }
}
