<?php


namespace app\helpers;


class TextHelper
{
    /**
     * Makes text "This is name" to "this-is-name"
     * @param string $text
     * @return string
     */
    public static function textToPath($text)
    {
        $text = strtolower($text);
        $word_pattern = '~(?<word>[a-zA-Z0-9]+)~';
        preg_match_all($word_pattern, $text, $matches);
        $result = implode('-', $matches['word']);
        return $result;
    }
}