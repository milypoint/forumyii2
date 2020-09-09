<?php

namespace app\helpers;

class IntegerEncoder
{
    const code_set="LtWscQOmy8akl407x6DbKSAfNnopqrHJgd12Y9TBXIuVZ3RMhUF5PejvGCiEwz";

    /**
     * @param int $n
     * @return string
     */
    public static function encode($n)
    {
        $code_set = self::code_set;
        $base = strlen($code_set);
        $converted = "";

        while ($n > 0) {
            $converted = substr($code_set, ($n % $base), 1) . $converted;
            $n = floor($n/$base);
        }
        return $converted;
    }

    /**
     * @param string $converted
     * @return int
     */
    public static function decode($converted)
    {
        $code_set = self::code_set;
        $base = strlen($code_set);
        $c = 0;
        for ($i = strlen($converted); $i; $i--) {
            $c += strpos($code_set, substr($converted, (-1 * ( $i - strlen($converted) )),1))
                * pow($base,$i-1);
        }
        return $c;
    }
}