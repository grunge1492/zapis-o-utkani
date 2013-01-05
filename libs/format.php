<?php

class Format
{
    static public function niconv() {
        return array(
            "ě" => "e",
            "é" => "e",
            "ë" => "e",
            "š" => "s",
            "ś" => "s",
            "č" => "c",
            "ř" => "r",
            "ž" => "z",
            "ý" => "y",
            "á" => "a",
            "ä" => "a",
            "í" => "i",
            "ú" => "u",
            "ů" => "u",
            "ü" => "u",
            "ó" => "o",
            "ö" => "o",
            "Ö" => "O",
            "Ó" => "O",
            "Ě" => "E",
            "É" => "E",
            "Ë" => "E",
            "Š" => "S",
            "Ś" => "S",
            "Č" => "C",
            "Ř" => "R",
            "Ž" => "Z",
            "Ý" => "Y",
            "Á" => "A",
            "Ä" => "A",
            "Í" => "I",
            "Ú" => "U",
            "Ů" => "U",
            "Ü" => "U",
            "ť" => "t",
            "Ť" => "T",
            "ň" => "n",
            "ń" => "n",
            "Ň" => "N",
            "Ń" => "N",
            "ď" => "d",
            "Ď" => "D",
        );
    }
    
    static public function makeSeoUrl($ret)
    {
        $new_ret = strtolower(strtr($ret, Format::niconv()));
        $new_ret = str_replace(" ", "-", $new_ret);

        return Trim($new_ret, ".");
    }
}
