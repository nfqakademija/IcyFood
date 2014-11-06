<?php

namespace NfqAkademija\RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NfqAkademija\RecipeBundle\Entity\Image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $images = [
            ['recipe-1', 'Bulvių paplotėliai su varške', '0805ed46ff9196e51c8c762de2b489130121d43c.jpeg'],
            ['recipe-2', 'Bulvių košė', '923c0217289faa9677b554ed16094057e3954845.jpeg'],
            ['recipe-3', 'apkepti makaronai', '03597680c5d40ce80205c6a33c67ce5267f4b1d8.jpeg'],
            ['recipe-4', 'karšti sumuštiniai', 'ec7d685dc1a74f1a7a2246068c67e2bd72dc8215.jpeg']

        ];

        foreach($images as $image){
            $data = new Image();
            $data->setName($image[1]);
            $data->setPath($image[2]);
            $data->setRecipe($this->getReference($image[0]));
            $manager->persist($data);
        }

        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 4;
    }
}
