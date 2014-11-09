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
            ['recipe-4', 'Karšti sumuštiniai su kumpiu ir pomidorais', 'Šešios baltos sumuštinių duonos riekelės sudedamos į kepimo skardą. Ant kiekvienos duonos riekelės dedama po griežinėlį kumpio. Likusiom duonos riekelėm išpjaunamas minkštimas (aplink plutelę paliekant apie 0,5-1 cm). Išpjautos duonos riekelės sudedamos ant kumpio griežinėlių. Ant kiekvieno sumuštinio uždedama po vieną ar du griežinėlius pomidoro, įmušami du putpelių kiaušiniai (arba vienas vištos kiaušinis). Pabarstoma druska, pipirais, džiovintu baziliku. Dedama į įkaitintą orkaitę ir kepama 180 laipsnių temperatūroje apie 20-25 min. Karšti sumuštiniai su kumpiu ir pomidorais puikiai tinka savaitgalio pusryčiams visai šeimai. Skanaus.'],
            ['recipe-5', 'Blyneliai su obuoliais', 'Į dubenį įmušami kiaušiniai, suberiamas cukrus, supilamas kefyras ir viskas gerai išplakama. Miltai sumaišomi su kepimo milteliais, druska ir suberiami į kefyro masę. Užmaišoma grietinės tirštumo blynelių tešla. Obuoliai nulupami ir supjaustomi nedideliais gabaliukais arba skiltelėmis. Į blynelių tešlą suberiamas cinamonas, sudedami obuoliai ir atsargiai išmaišoma. Į keptuvę įpilamas šlakelis aliejaus, įkaitinama, dedama po šaukštą tešlos ir kepama iš abiejų pusių, kol blyneliai su obuoliais gražiai pagelsta. Blyneliai su obuoliais patiekiami su uogiene arba grietine. Skanaus.'],
            ['recipe-6', 'Tortas Napoleonas', 'Ant medinės lentos paberiame miltus, užbarstome druskos, padarome duobutę, supilame grietinę, įmušame kiaušinį, sudedame atšaldyto sviesto gabaliukus ir kapojame tol, kol nelieka sausų miltų. Tada tešlą suspaudžiame į rutuliuką, pridengiame ir atšaldome. Imame po nedidelį tešlos gabaliuką ir kočiojame plonyčius papločius.\r\n\r\nApipjauname pagal pageidaujamo dydžio formą ir subadome šakute. Skardą išklojame kepimo popieriumi, šiek tiek sudrėkiname vandeniu, dedame paplotį ir kepame 170-180 laipsnių temperatūroje, kol gražiai pagelsta. Taip išsikepame visus torto papločius.\r\n\r\nNuopjovas taip pat išsikepame, nes bus reikalingos apibarstymui. Atvėsusias nuopjovas sutrupiname.\r\nTorto Napoleonas kremui skirtą sviestą išlydome, suberiame miltus ir maišant pakaitiname, kol miltai pradeda gelsti. Atskirai užviriname pieną su cukrumi ir plona srovele stipriai maišant supilame į sviestą su miltais. Nuolat maišant truputį pakaitiname, nukeliame nuo ugnies ir atvėsiname. Tada po vieną įmušame kiaušinio trynius, suberiame vanilinį cukrų ir gerai išplakame, kol kremas tortui pasidaro purus.\r\nAtvėsusius torto papločius pertepame paruoštu kremu, truputį paspaudžiame. Galima vieną paplotį pertepti rūgštesne uogiene (pvz. spanguolių). Torto viršų ir kraštus aptepame kremu ir apibarstome trupiniais. Perteptas tortas Napoleonas išlaikomas per naktį, kad kremas geriau įsigertų į papločius. Skanaus.'],
            ['recipe-7', 'Plovas su kiauliena', 'Morką nuskutame ir supjaustome plonais griežinėliais. Svogūną nulupame ir supjaustome, papriką supjaustome nedideliais gabaliukais. Kiaulieną švariai nuplauname, nusausiname ir supjaustome nedideliais gabaliukais kaip kiaulienos guliašui. Į įkaitintą keptuvę įpilame aliejaus ir apkepiname morkas, papriką bei svogūnus.\r\n\r\nPerdedame apkepintas daržoves į kitą keptuvę, puodą ar troškintuvą. Pirmoje keptuvėje apkepiname kiaulieną ir sudedame ant jau apkepintų daržovių. Skystį, kuris išsiskyrė kepant, ir likusį aliejų taip pat supilame. Įdedame druskos, maltų pipirų pagal skonį. Ant viršaus supilame ir tolygiai paskleidžiame po šaltu vandeniu perplautus ryžius. Įpilame verdančio vandens, kad apsemtų ryžius. Tarp ryžių įspraudžiame nenuluptas česnako skilteles.\r\n\r\nGerai uždengiame. Troškinamas plovas su kiauliena apie 20 min. ant mažos ugnies. Nudengiame, plovas gerai išmaišomas, jei trūksta įpilame truputį verdančio vandens, vėl uždengiame. Kiaulienos plovas dar patroškinamas kol suminkštėja ryžiai. Kiaulienos plovas pabarstomas krapais, į plovą išspaudžiama tyrelė iš išsitroškinusių česnakų skiltelių (išspaustos išmetamos), viskas išmaišoma ir paliekama keletui minučių. Šiuo metodu greitai ir pakankamai lengvai paruošiamas plovas nėra visai tradicinis, tačiau skoniu ir aromatu tikrai nenuvils. Skanaus.'],
            ['recipe-8', 'Žemaičių blynai', 'Bulves (su lupenomis) švariai nuplauname ir išverdame. Atvėsiname, nulupame ir sumalame mėsmale. Į bulvių masę įmušame kiaušinį, suberiame krakmolą, 5 šaukštus miltų, druskos ir išminkome.\r\n\r\nSvogūną smulkiai supjaustome ir apkepiname svieste. Virtą mėsą žemaičių blynams sumalame, sudedame pakepintus svogūnus, įberiame druskos, pipirų ir gerai išmaišome.\r\n\r\nIš bulvių tešlos darome paplotėlius, įdedame mėsos įdaro ir formuojame ovalius žemaičių blynus.\r\n\r\nŽemaičių blynai apvoliojami likusiuose miltuose.\r\n\r\nir kepami aliejuje ant nestiprios ugnies, kol gražiai apskrunda.\r\n\r\nŽemaičių blynai valgomi su grietine. Labai skanu su džiovintų grybų padažu. Gero apetito.'],
            ['recipe-9', 'Čeburėkai', 'Soda nugesinama su kefyru. Į dubenį supilami miltai, kefyras, įberiama druskos ir užminkoma tešla. Tešla uždengiama ir paliekama 15 - 20 min. pastovėti.\r\nParuošiamas čeburėkų įdaras: kiaulienos faršas sumaišomas su smulkiai pjaustytais svogūnais, druska ir pipirais. Įpilama mėsos sultinio ir gerai išmaišoma. \r\nAnt miltais pabarstyto stalo iškočiojamas 2 - 2,5 mm storio tešlos lakštas ir išspaudžiami 15 - 20 cm skersmens apskritimai. Į kiekvieną apskritimą dedama po šaukštą mėsos įdaro, perlenkiama, užspaudžiami kraštai.\r\n\r\nSvarbu, kad neliktų jokių plyšelių, nes mėsos sultys išbėgs ir čeburėkai bus sausi. Čeburėkai kepami įkaitintame aliejuje iš abiejų pusių, kol gražiai pagelsta.\r\n\r\nIškepę čeburėkai sudedami ant popierinio rankšluosčio, kad susigertų riebalai.'],
            ['recipe-10', 'Šnicelis', 'Duona užpilama pienu (plutelės nupjaunamos). Į kiaulienos faršą įmušamas vienas kiaušinis, sudedama išmirkyta nuspausta duona, suberiamas smulkiai supjaustytas česnakas (galima ir išspausti), įberiama druskos, pipirų ir gerai išmaišoma.\r\nIš paruošto faršo formuojami pailgi, ovalios formos, 7-8 mm storio šniceliai. Kiekvienas šnicelis pamirkomas kiaušinio plakinyje, pavoliojamas džiūvėsėliuose ir kepamas įkaitintame aliejuje iš abiejų pusių. Šnicelis skanu su bulvių koše, virtais grikiais ir daržovių salotomis. Skanaus.'],


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
