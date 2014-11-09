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
            ['recipe-4', 'karšti sumuštiniai', 'ec7d685dc1a74f1a7a2246068c67e2bd72dc8215.jpeg'],
            ['recipe-5', 'Blyneliai su obuoliais', 'e468b3f8684f559d310eb57e27283e9428ef7462.jpeg'],
            ['recipe-6', 'Tortas Napoleonas', 'b9c15cfcb68db8303e41323e6665f40b39b257d6.jpeg'],
            ['recipe-6', 'Tortas Napoleonas', '4efaedd2e9ebd56f2f7e07f7be24d6f4f470f34f.jpeg'],
            ['recipe-6', 'Tortas Napoleonas', 'a4dca257693643d98238583ece06174f18a862b3.jpeg'],
            ['recipe-7', 'Plovas su kiauliena', '8e5db6c5118682ebc32c76d5d082e61c2a464cea.jpeg'],
            ['recipe-7', 'Plovas su kiauliena', 'a245ae81d3f20eb60850aae6c19ad22d41a3a6c9.jpeg'],
            ['recipe-7', 'Plovas su kiauliena', 'e31049f7b7016610c00e169e7773ee7703b609cb.jpeg'],
            ['recipe-8', 'Žemaičių blynai', 'ebaed38cd9ce2eed3ce7d5ff524408d8083463ce.jpeg'],
            ['recipe-8', 'Žemaičių blynai', 'a827f09e33c4b9cd7dce16f4f227cb6d41ba86df.jpeg'],
            ['recipe-8', 'Žemaičių blynai', 'af9d42192a57351a048ff1bf2dd4e30ea18a760d.jpeg'],
            ['recipe-8', 'Žemaičių blynai', '1dd1f90f7362dee87011ed399476028bdf80d4a0.jpeg'],
            ['recipe-8', 'Žemaičių blynai', '76f3bbeac2e6c98fea84c7463266554a307de406.jpeg'],
            ['recipe-8', 'Žemaičių blynai', '26a572236cdc7996e05d0d6f2d1b37280a32a99d.jpeg'],
            ['recipe-9', 'Čeburėkai', 'b11546355f2561fbdaac4937a74ec7d2e32163af.jpeg'],
            ['recipe-9', 'Čeburėkai', '5ea8047c7baaa91963daea920bd0402373d64be5.jpeg'],
            ['recipe-9', 'Čeburėkai', '618521faee142825b5736019a3cff72e6d9ba97f.jpeg'],
            ['recipe-9', 'Čeburėkai', '54e716b261b80642d59170ba5e563926d41c5fb0.jpeg'],
            ['recipe-10', 'Šnicelis', 'd17985cc0bc859398124c288e2bd2b7d1c92d5fa.jpeg'],


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
