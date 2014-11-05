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
            ['arbatinis šaukštelis', 'arb. šauk.',  'unit-1'],
            ['butelis',              'but.',        'unit-2'],
            ['centimetras',          'cm',          'unit-3'],
            ['gabalas',              'gab.',        'unit-4'],
            ['galva',                'galv.',       'unit-5'],
            ['gramas',               'g',           'unit-6'],
            ['gūželė',               'gūž.',        'unit-7'],
            ['kilogramas',           'kg',          'unit-8'],
            ['lapas',                'lap.',        'unit-9'],
            ['lašas',                'laš.',        'unit-10'],
            ['litras',               'l',           'unit-11'],
            ['mililitras',           'ml',          'unit-12'],
            ['pakelis',              'pak.',        'unit-13'],
            ['pundelis',             'pund.',       'unit-14'],
            ['riekė',                'riek.',       'unit-15'],
            ['sauja',                'sauj.',       'unit-16'],
            ['saujelė',              'saujel.',     'unit-17'],
            ['skardinė',             'skard.',      'unit-18'],
            ['skiltelė',             'skilt.',      'unit-19'],
            ['stiklinė',             'stikl.',      'unit-20'],
            ['valgomasis šaukštas',  'valg. šaukš.','unit-21'],
            ['vienetas',             'vnt.',        'unit-22'],
            ['žiupsnelis',           'žiups.',      'unit-23']
        ];

        foreach($units as $unit){
            $data = new Unit();
            $data->setName($unit[0]);
            $data->setShort($unit[1]);
            $manager->persist($data);

            $this->addReference($unit[2], $data);
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
