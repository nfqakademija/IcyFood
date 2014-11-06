<?php

namespace NfqAkademija\RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NfqAkademija\RecipeBundle\Entity\RecipeIngredient;

class LoadRecipeIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $raws = [
            ['recipe-1',	'ingredient-82',	'unit-22',	'4'],
            ['recipe-1',	'ingredient-614',	'unit-6',	'250'],
            ['recipe-1',	'ingredient-358',	'unit-6',	'80'],
            ['recipe-1',	'ingredient-244',	'unit-22',	'1'],
            ['recipe-1',	'ingredient-124',	'unit-1',	'1'],
            ['recipe-1',	'ingredient-87',	'unit-1',	'0.25'],
            ['recipe-2',	'ingredient-82',	'unit-22',	'6'],
            ['recipe-2',	'ingredient-558',	'unit-6',	'40'],
            ['recipe-2',	'ingredient-409',	'unit-12',	'150'],
            ['recipe-2',	'ingredient-124',	'unit-1',	'1'],
            ['recipe-3',	'ingredient-326',	'unit-6',	'300'],
            ['recipe-3',	'ingredient-362',	'unit-6',	'125'],
            ['recipe-3',	'ingredient-578',	'unit-6',	'75'],
            ['recipe-3',	'ingredient-421',	'unit-22',	'3'],
            ['recipe-3',	'ingredient-107',	'unit-19',	'1'],
            ['recipe-3',	'ingredient-15',	'unit-21',	'1.5'],
            ['recipe-3',	'ingredient-68',	'unit-21',	'1'],
            ['recipe-3',	'ingredient-124',	'unit-23',	'1'],
            ['recipe-3',	'ingredient-189',	'unit-23',	'1'],
            ['recipe-4',	'ingredient-127',	'unit-15',	'12'],
            ['recipe-4',	'ingredient-291',	'unit-19',	'6'],
            ['recipe-4',	'ingredient-421',	'unit-6',	'150'],
            ['recipe-4',	'ingredient-244',	'unit-22',	'6'],
            ['recipe-4',	'ingredient-124',	'unit-1',	'1'],
            ['recipe-4',	'ingredient-189',	'unit-1',	'1'],
            ['recipe-4',	'ingredient-68',	'unit-21',	'2']

        ];

        foreach($raws as $raw){
            $data = new RecipeIngredient();
            $data->setRecipe($this->getReference($raw[0]));
            $data->setIngredient($this->getReference($raw[1]));
            $data->setUnit($this->getReference($raw[2]));
            $data->setQuantity($raw[3]);

            $manager->persist($data);
        }

        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 5;
    }
}
