<?php

namespace NfqAkademija\RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NfqAkademija\RecipeBundle\Entity\Recipe;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $recipes = [
            ['recipe-1', 'Bulvių paplotėliai su varške', 'Bulvės švariai nuplaunamos ir išverdamos su lupenomis. Išvirusios bulvės nulupamos ir gerai sugrūdamos. Į sugrūstą bulvių masę sudedama varškė, įmušamas kiaušinis, suberiama druska, ciberžolė ir viskas gerai išminkoma. Rankos patepamos aliejumi ir formuojami nedideli paplotėliai. Kepama įkaitintame aliejuje iš abiejų pusių, kol gražiai pagelsta. Bulvių paplotėliai su varške patiekiami su grietine. Skanaus.'],
            ['recipe-2', 'Bulvių košė', 'Bulves nuskutame ir išverdame pasūdytame vandenyje. Išvirusias bulves nugariname, įdedame sviesto ir sugrūdame. Pamažu pilame užvirintą karštą pieną ir grūsdami išsukame iki vientisos masės. Bulvių košę galima patiekti su džiovintų grybų padažu, spirgučių padažu. Bulvių košė tinka su kotletais, kepsniais, dešrelėmis, žuvies patiekalais. Skanaus.'],
            ['recipe-3', 'Apkepti makaronai su sūriu ir špinatais', 'Puode užvirinamas vanduo, įberiama druskos, sudedami makaronai ir paverdama iki \"al dente\" (turi būti šiek tiek kietoki). Makaronai supilami į kiaurasamtį, perliejami šaltu vandeniu ir nuvarvinami. \r\nPomidorai kelioms sekundėms panardinami į verdantį vandenį, perliejami šaltu vandeniu, nulupami ir supjautomi gabaliukais. Į keptuvę įpilamas 1 valg. š. alyvuogių aliejaus, įkaitinama ir pakepinamas česnakas, kol pradeda skleisti aromatą. Česnakas išimamas iš keptuvės, suberiami špinatai, supjaustyti pomidorai ir pakepinama apie 4 -5 min. \r\nMakaronai sudedami į alyvuogių aliejumi išteptą kepimo formą, pabarstoma pipirais ir užpilami špinatų-pamidorų mase. Pabarstoma susmulkintu baziliku, sutarkuotu mocarelos sūriu ir dedama į įkaitintą orkaitę. Kepama 180 laipsnių temperatūroje apie 15 min. Apkepti makaronai su sūriu ir špinatais patiekiami su mėgstamomis daržovių salotomis. Skanaus.'],
            ['recipe-4', 'Karšti sumuštiniai su kumpiu ir pomidorais', 'Šešios baltos sumuštinių duonos riekelės sudedamos į kepimo skardą. Ant kiekvienos duonos riekelės dedama po griežinėlį kumpio. Likusiom duonos riekelėm išpjaunamas minkštimas (aplink plutelę paliekant apie 0,5-1 cm). Išpjautos duonos riekelės sudedamos ant kumpio griežinėlių. Ant kiekvieno sumuštinio uždedama po vieną ar du griežinėlius pomidoro, įmušami du putpelių kiaušiniai (arba vienas vištos kiaušinis). Pabarstoma druska, pipirais, džiovintu baziliku. Dedama į įkaitintą orkaitę ir kepama 180 laipsnių temperatūroje apie 20-25 min. Karšti sumuštiniai su kumpiu ir pomidorais puikiai tinka savaitgalio pusryčiams visai šeimai. Skanaus.']

        ];

        foreach($recipes as $recipe){
            $data = new Recipe();
            $data->setName($recipe[1]);
            $data->setInstructions($recipe[2]);
            $manager->persist($data);

            $this->addReference($recipe[0], $data);
        }

        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 3;
    }
}
