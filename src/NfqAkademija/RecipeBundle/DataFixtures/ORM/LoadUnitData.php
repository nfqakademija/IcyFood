<?php

namespace NfqAkademija\RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NfqAkademija\RecipeBundle\Entity\Unit;

class LoadUnitData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $units = [
            ['arbatinis šaukštelis', 'arb. šauk.'],
            ['butelis',              'but.'],
            ['centimetras',          'cm'],
            ['gabalas',              'gab.'],
            ['galva',                'galv.'],
            ['gramas',               'g'],
            ['gūželė',               'gūž.'],
            ['kilogramas',           'kg'],
            ['lapas',                'lap.'],
            ['lašas',                'laš.'],
            ['litras',               'l'],
            ['mililitras',           'ml'],
            ['pakelis',              'pak.'],
            ['pundelis',             'pund.'],
            ['riekė',                'riek.'],
            ['sauja',                'sauj.'],
            ['saujelė',              'saujel.'],
            ['skardinė',             'skard.'],
            ['skiltelė',             'skilt.'],
            ['stiklinė',             'stikl.'],
            ['valgomasis šaukštas',  'valg. šaukš.'],
            ['vienetas',             'vnt.'],
            ['žiupsnelis',           'žiups.']
        ];

        foreach($units as $unit){
            $data = new Unit();
            $data->setName($unit[0]);
            $data->setShort($unit[1]);
            $manager->persist($data);
        }
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 2;
    }
}