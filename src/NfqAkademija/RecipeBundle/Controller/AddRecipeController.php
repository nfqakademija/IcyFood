<?php

namespace NfqAkademija\RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AddRecipeController extends Controller
{
    /**
     * @Route("/naujas", name="new_recipe")
     * @Template()
     */
    public function newAction()
    {
        return array(
                // ...
            );
    }

}
