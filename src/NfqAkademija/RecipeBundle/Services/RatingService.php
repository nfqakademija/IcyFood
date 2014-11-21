<?php

namespace NfqAkademija\RecipeBundle\Services;

use Doctrine\ORM\EntityManager;

class RatingService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $ip
     * @param array $recipes
     *
     * @return array
     */
    public function addRatingByIp($ip, $recipes)
    {
        foreach($recipes as &$r) {
            $readOnly = false;
            $rating = 0;
            $total = "";

            $recipeRating = $r["recipe"]->getRecipeRating();
            if($recipeRating){
                $rating = $recipeRating->getAverage();
                $total = $recipeRating->getTotal();
            }

            $votes = $r["recipe"]->getVotes();

            if(!$votes->isEmpty()){
                foreach($votes as $vote){
                    if ($ip == $vote->getIp()) {
                        $readOnly = true;
                        $rating = $vote->getGrade();
                        $total = "";
                    }
                }
            }

            $r["rating"] = $rating;
            $r["total"] = $total;
            $r["readonly"] = $readOnly;
        }

        return $recipes;
    }

}