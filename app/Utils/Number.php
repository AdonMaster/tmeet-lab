<?php


namespace App\Utils;


class Number
{
    /**
     * @param string $str
     * ex.: ',87' => 0.87
     * @return double
     */
    public static function brToFloat1($str)
    {
        $v = str_replace('.', '', $str);
        $v = str_replace(',', '.', $v);
        return doubleval($v);
    }
}