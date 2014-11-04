<?php

namespace NfqAkademija\RecipeBundle\Controller;

use NfqAkademija\RecipeBundle\Entity\Recipe;
use NfqAkademija\RecipeBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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

            $em->persist($recipe);
            $em->flush();

            return $this->redirect($this->generateUrl('recipe_homepage'));
        }

        return $this->render(
            'RecipeBundle:AddRecipe:new.html.twig',
            array('form' => $form->createView())
        );
    }


}
