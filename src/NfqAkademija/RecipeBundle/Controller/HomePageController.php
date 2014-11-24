<?php

namespace NfqAkademija\RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Route("/{any}", name="any", requirements={"any" = ".*"})
     * @Template("RecipeBundle:HomePage:index.html.twig")
     */
    public function anyAction($any)
    {
        return array();
    }
}
