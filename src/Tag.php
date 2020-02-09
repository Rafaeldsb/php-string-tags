<?php
declare(strict_types=1);

namespace RafaelDsb\Helpers;

/**
*  A helper who assist in string tags.
*
*  @author rafaeldsb
*/
class Tag {

    /**
     * This method returns all tags contained in the given string
     *
     * @param string $string Original string containing tags. eg => 'This text contains the tag {{tag}}'
     * @param string $leftCharTag Initial character of the tag. default '{{'
     * @param string $rightCharTag Final character of the tag. default '}}
     * @return array<string> Returns an array containing all tags without repeating them
     */
    public static function getTags(string $string, string $leftCharTag = '{{', string $rightCharTag = '}}'): array {
        $matches = [];

        $lCharTag = self::normalizeKeyChar($leftCharTag);
        $rCharTag = self::normalizeKeyChar($rightCharTag);

        preg_match_all("~{$lCharTag}(.*?){$rCharTag}~", $string, $matches);

        return array_unique($matches[1]);
    }

    /**
     * This method will replace the original string with the entered tags, returning a new string
     *
     * @param string $string Original string containing tags. eg => 'This text contains the tag {{tag}}'
     * @param array<string, string> $tags Array of tags containing the key and value. eg => ['key1' => 'Any value', 'otherKey' => 'Another Value']
     * @param string $leftCharTag Initial character of the tag. default '{{'
     * @param string $rightCharTag  Final character of the tag. default '}}
     * @return string Returns the original string replaced with the tags
     */
    public static function replaceTags(string $string, array $tags, string $leftCharTag = '{{', string $rightCharTag = '}}'): string {

        foreach ($tags as $key => $value) {
            $tag = $leftCharTag . $key . $rightCharTag;
            $string = strtr($string, [$tag => $value]);
        }

        return $string;
    }

    private static function normalizeKeyChar(string $key): string {
       return '\\' . implode('\\', str_split($key));
    }
}