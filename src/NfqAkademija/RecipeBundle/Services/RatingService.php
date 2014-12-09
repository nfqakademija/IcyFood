<?php

namespace NfqAkademija\RecipeBundle\Services;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use NfqAkademija\RecipeBundle\Entity\Votes;
use NfqAkademija\RecipeBundle\Entity\Recipe;
use NfqAkademija\RecipeBundle\Entity\RecipeRating;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Common\Persistence\ObjectManager;


class RatingService
{

    protected $em;

    protected $request;


    public function setRequest(RequestStack $request_stack)
    {
        $this->request = $request_stack->getCurrentRequest();
    }

    public function setEntityManager(ObjectManager $em){
        $this->em = $em;
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

    public function postRatingAction($data)
    {  
        $voteData = json_decode($data, true);
        $id = $voteData['id'];
        $grade = $voteData['rating'];
        $ip = $this->request->getClientIp();

        $votes_repo = $this->em->getRepository('RecipeBundle:Votes');

        if($votes_repo->hasUserVoted($voteData['id'], $ip)){
            return false;
        }

        // Record user vote.
        $recipe_repo = $this->em->getRepository('RecipeBundle:Recipe');
        $recipe = $recipe_repo->find($voteData['id']);
        $votes = new Votes();
        $votes->setRecipe($recipe);
        $votes->setGrade($voteData['rating']);
        $votes->setIp($ip);
        $this->em->persist($votes);
        $this->em->flush();

        // Get old average rating
        $recipe = $recipe_repo->find($id);
        $recipeRating = $recipe->getRecipeRating();

        // Average rating for that recipe does not exist so let's create one.
        if(!$recipeRating){
            $recipeRating = new RecipeRating();
            $recipeRating->setRecipe($recipe);
            $recipeRating->setAverage($grade);
            $recipeRating->setTotal(1);
            $this->em->persist($recipeRating);
            $this->em->flush();

            return;
        }

        // Calculate new average rating.
        $average = $recipeRating->getAverage();
        $total = $recipeRating->getTotal();
        $voteWeight = round($grade / ($total + 1), 2);
        $avgWeight = round(($average / ($total + 1)) * $total, 2);
        $newRating = $voteWeight + $avgWeight;

        // Update rating.
        $recipeRating->setAverage($newRating);
        $recipeRating->setTotal($total + 1);
        $this->em->flush();
    }
}