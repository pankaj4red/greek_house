<?php

namespace App\Helpers\FakeProviders;

class LoremIpsumFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'lorem',
        'ipsum',
        'dolor',
        'sit',
        'amet',
        'consectetur',
        'adipiscing',
        'elit',
        'sed',
        'do',
        'eiusmod',
        'tempor',
        'incididunt',
        'ut',
        'labore',
        'et',
        'dolore',
        'magna',
        'aliqua',
        'Ut',
        'enim',
        'ad',
        'minim',
        'veniam',
        'quis',
        'nostrud',
        'exercitation',
        'ullamco',
        'laboris',
        'nisi',
        'ut',
        'aliquip',
        'ex',
        'ea',
        'commodo',
        'consequat',
        'Duis',
        'aute',
        'irure',
        'dolor',
        'in',
        'reprehenderit',
        'in',
        'voluptate',
        'velit',
        'esse',
        'cillum',
        'dolore',
        'eu',
        'fugiat',
        'nulla',
        'pariatur',
        'Excepteur',
        'sint',
        'occaecat',
        'cupidatat',
        'non',
        'proident',
        'sunt',
        'in',
        'culpa',
        'qui',
        'officia',
        'deserunt',
        'mollit',
        'anim',
        'id',
        'est',
        'laborum',
    ];

    private function loremIpsumWord()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }

    private function loremIpsumComma()
    {
        return rand(1, 10) == 1 ? ',' : '';
    }

    private function loremIpsumSentence()
    {
        $sentence = ucfirst($this->loremIpsumWord());
        $wordCount = rand(5, 20);
        for ($i = 1; $i < $wordCount - 1; $i++) {
            $sentence .= $this->loremIpsumWord().$this->loremIpsumComma().' ';
        }

        return $sentence.$this->loremIpsumWord().'.';
    }

    public function lorem_ipsum($sentenceCount = 3)
    {
        $text = '';
        for ($i = 0; $i < $sentenceCount - 1; $i++) {
            $text .= $this->loremIpsumSentence().' ';
        }
        $text .= $this->loremIpsumSentence();

        return $text;
    }
}