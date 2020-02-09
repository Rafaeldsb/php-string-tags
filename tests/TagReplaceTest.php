<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RafaelDsb\Helpers\Tag;

class TagReplaceTest extends TestCase
{


    public function testReplaceWithoutTags()
    {
        $stringsToTest = ['testando' => 'testando', 'testando o teste' => 'testando o teste'];

        foreach ($stringsToTest as $shouldReturn => $string) {
            $this->assertEquals($shouldReturn, Tag::replaceTags($string, []));
        }
    }

    public function testReplace()
    {
        $stringsToTest = [
            'testando 123' => ['testando {{key1}}', ['key1' => 123]],
            'teste xyak aaa 888x' => ['teste {{key2}} aaa {{other_key}}', ['key2' => 'xyak', 'other_key' => '888x']],
            'churrasco com cerveja no sábado' => ['churrasco com {{drink}} no {{day_week}}', ['drink' => 'cerveja', 'day_week' => 'sábado']]
        ];

        foreach ($stringsToTest as $shouldReturn => $string) {
            $this->assertEquals($shouldReturn, Tag::replaceTags($string[0], $string[1]));
        }
    }

    public function testReplaceWithOtherTags()
    {
        $stringsToTest = [
            'testando 123' => ['testando [[key1]]', ['key1' => 123], '[[', ']]'],
            'teste xyak aaa 888x' => ['teste {{key2]] aaa {{other_key]]', ['key2' => 'xyak', 'other_key' => '888x'], '{{', ']]'],
            'churrasco com cerveja no sábado' => ['churrasco com <drink> no <day_week>', ['drink' => 'cerveja', 'day_week' => 'sábado'], '<', '>']
        ];

        foreach ($stringsToTest as $shouldReturn => $string) {
            $this->assertEquals($shouldReturn, Tag::replaceTags($string[0], $string[1], $string[2], $string[3]));
        }
    }


    public function testReplaceInCascade()
    {
        $stringsToTest = [
            'testando XXX' => ['testando {{{{subkey}}a}}', ['subkey' => 123, '123a' => 'XXX'], '{{', '}}'],
            'teste YYY ZZZ' => ['teste {{{{key1]]_123]] {{key2]]', ['key1' => 'abc', 'abc_123' => 'YYY', 'key2' => 'ZZZ'], '{{', ']]'],
            'churrasco com Pinga de 1L' => ['churrasco com <<drink>_name> de <<drink>_ml>', ['drink' => 'pinga', 'pinga_name' => 'Pinga', 'pinga_ml' => '1L'], '<', '>']
        ];

        foreach ($stringsToTest as $shouldReturn => $string) {
            $this->assertEquals($shouldReturn, Tag::replaceTags($string[0], $string[1], $string[2], $string[3]));
        }
    }
}
