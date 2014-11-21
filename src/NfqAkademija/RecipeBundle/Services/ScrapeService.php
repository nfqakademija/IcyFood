<?php

namespace NfqAkademija\RecipeBundle\Services;

use Goutte\Client;

class ScrapeService
{
    private $content;
    private $name;
    private $ingredients;
    private $instructions;
    private $images;

    public function __construct($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $this->content = $crawler->filterXPath("//div[@class='tekstas']");
        $this->scrape();
    }

    private function scrape()
    {
        $this->name         = $this->content->filterXPath("//h1")->text();
        $this->ingredients  = $this->scrapeIngredients();
        $this->instructions = $this->scrapeInstructions();
        $this->images       = $this->scrapeImages();
    }

    private function scrapeIngredients()
    {
        $raw = $this->content->filterXPath("//div[@class='tekstas_cont']/p[1]");
        $ret = [];
        foreach ($raw->getNode(0)->childNodes as $node) {
            if ($node->nodeName === '#text') {
                if (strlen(trim($node->wholeText)) > 4) {
                    $ret[] = $this->trimAll($node->wholeText);
                }
            }
        }

        return $ret;
    }

    private function scrapeInstructions()
    {
        $raw = $this->content->filterXPath("//div[@class='tekstas_cont']");
        $ret = "";
        $count = 0;
        foreach ($raw->getNode(0)->childNodes as $node) {
            if ($node->nodeName === '#text') {
                if (strlen(trim($node->wholeText)) > 4) {
                    $ret .= $this->trimAll($node->wholeText)."\n\n";
                }
            }
            if ($node->nodeName === 'p' && ++$count!=1) {
                if (strlen(trim($node->nodeValue)) > 4) {
                    $ret .= $this->trimAll($node->nodeValue)."\n\n";
                }
            }
        }

        return trim($ret);
    }

    private function scrapeImages()
    {
        $list = $this->content->filterXPath("//img")->extract(['src']);;
        $images = preg_grep('/^.*pav\/galery.*$/', $list);


        return $images;
    }

    private function trimAll($string)
    {
        $search = ["\n"];

        return str_replace($search, "\n\n", $string);
    }

    public function getName()
    {
        return $this->content->filterXPath("//h1")->text();
    }

    public function getInstructions()
    {
        return $this->instructions;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getIngredientsRaw()
    {
        return $this->ingredients;
    }

    public function getIngredients()
    {
        $ingr = [];

        foreach($this->ingredients as $ingredient)
        {
            $quantity = preg_match('/[\d-]+/',$ingredient,$match) ? $match[0] : "";
            $unit = preg_match('/(?:\s([a-ž]{1,3}\.?(?:\s[a-ž]\.)?)\s)/',$ingredient,$match) ? $match[1] : "";
            $name = trim(str_replace([$quantity,$unit],"", $ingredient));
            $ingr[] = ['name' => $name, 'quantity' => $quantity, 'unit' => $unit];
        }

        return $ingr;
    }
}