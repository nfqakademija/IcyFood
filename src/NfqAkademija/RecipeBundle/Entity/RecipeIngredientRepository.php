<?php

namespace NfqAkademija\RecipeBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * RecipeIngredientRepository
 */
class RecipeIngredientRepository extends EntityRepository
{
    public function getIngredients($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("

            SELECT ri, rii, riu
            FROM RecipeBundle:RecipeIngredient ri
            LEFT JOIN ri.ingredient rii
            LEFT JOIN ri.unit riu
            WHERE ri.recipe = :id

        ")
            ->setParameter('id', $id);

        return $query->getResult();
    }
}
