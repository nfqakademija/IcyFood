<?php

namespace NfqAkademija\RecipeBundle\Services;

use Doctrine\Common\Persistence\ManagerRegistry;

class RatingService
{
    // usage: $entityManager = $this->managerRegistry->getManagerForClass(get_class($recipe));
    protected $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param string $ip
     * @param array $r
     *
     * @return array
     */
    public function addRatingByIp($ip, $r)
    {
        $readOnly = false;
        $rating = 0;
        $total = 0;

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
                }
            }
        }

        $r["rating"] = $rating;
        $r["total"] = $total;
        $r["readonly"] = $readOnly;

        return $r;
    }

    /**
     * @param string $ip
     * @param array $recipes
     *
     * @return array
     */
    public function addRatingByIpAll($ip, $recipes)
    {
        foreach($recipes as &$r) {
            $r = $this->addRatingByIp($ip, $r);
        }

        return $recipes;
    }
}