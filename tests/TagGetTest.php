<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RafaelDsb\Helpers\Tag;

class TagGetTest extends TestCase
{
    public function testShouldReturnEmpty()
    {
        $strings = [
            'Any string',
            'This {string} has no tag'
        ];

        foreach ($strings as $string) {
            $this->assertEmpty(Tag::getTags($string));
        }

    }

    public function testShouldReturnTags()
    {
        $strings = [
            ['Any {{string}}', ['string']],
            ['This {{string}} has {{tag}}', ['tag', 'string']]
        ];

        foreach ($strings as $string) {
            $tags = Tag::getTags($string[0]);
            $this->assertIsArray($tags);
            $this->assertCount(count($string[1]), $tags);
            foreach ($string[1] as $tag) {
                $this->assertContains($tag, $tags);
            }
        }
    }

    public function testShouldReturnTagsWithOtherCharKeys()
    {
        $strings = [
            ['Any [[string}}', ['string'], '[[', '}}'],
            ['This <string> has <tag>', ['tag', 'string'], '<', '>']
        ];

        foreach ($strings as $string) {
            $tags = Tag::getTags($string[0], $string[2], $string[3]);
            $this->assertIsArray($tags);
            $this->assertCount(count($string[1]), $tags);
            foreach ($string[1] as $tag) {
                $this->assertContains($tag, $tags);
            }
        }
    }
}