<?php

namespace NfqAkademija\RecipeBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\Annotations\Get;

class ApiController extends Controller
{
    /**
     * @Get("/recipe/{id}")
     */
    public function getRecipeAction($id){
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
    public function gpostRecipesAction(){
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('RecipeBundle:Recipe')->findAll();
//        if(!is_object($recipe)){
//            throw $this->createNotFoundException();
//        }
        return $recipes;
    }

}