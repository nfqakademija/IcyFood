<?php

namespace NfqAkademija\RecipeBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;

class RecipeService
{
    protected $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param ArrayCollection $ingredients
     * @param $offset
     * @param $limit
     *
     * @return array
     */
    public function getRecipesByIngredients($ingredients, $offset, $limit)
    {
        $em = $this->managerRegistry->getManagerForClass('RecipeBundle:Recipe');
        $rRepo = $em->getRepository('RecipeBundle:Recipe');
        $riRepo = $em->getRepository('RecipeBundle:RecipeIngredient');

        if($ingredients->isEmpty()) {
            return $rRepo->getByIngredients([], $offset, $limit);
        }

        $moreIngredients = $this->expandIngredients($ingredients);
        $ingIds = $moreIngredients->map(function($i){return $i->getId();})->toArray();

        $recipes = $rRepo->getByIngredients($ingIds, $offset, $limit);

        foreach($recipes as &$recipe){
            $recipe["recipe"]->setIngredientsCustom(new ArrayCollection($riRepo->getIngredients($recipe["recipe"]->getId())));
        }

        return $recipes;
    }

    /**
     * @param ArrayCollection $ingredients
     * @return ArrayCollection
     */
    public function expandIngredients(ArrayCollection $ingredients)
    {
        $moreIngredients = $ingredients->toArray();
        foreach ($ingredients as $ingredient) {
            $moreIngredients = array_merge(
                $moreIngredients,
                $ingredient->getParentsAndChildren()->toArray()
            );
        };
        $moreIngredients = new ArrayCollection($moreIngredients);

        return $moreIngredients;
    }
}
