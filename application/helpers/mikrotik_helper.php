<?php
//Mikrotik Helper

if( ! function_exists("mitime"))
{
    function mitime($text)
    {
        $replace = array(   "h"    => ":",
                            "m"    => ":",
                            "s"    => "");

        //Kondisi
        // 10s
        // 1m10s
        // 1h1m10s
        // 1h1m
        // 1m
        // 1h

        if(strlen(strpos($text,"s")) == 1 && strlen(strpos($text,"m")) == 0 && strlen(strpos($text,"h")) == 0)
        {
            $text = "00:00:" . strtr($text,$replace);
        }
        elseif(strlen(strpos($text,"s")) == 1 && strlen(strpos($text,"m")) == 1 && strlen(strpos($text,"h")) == 0)
        {
            $text = "00:" . strtr($text,$replace);
        }
        elseif(strlen(strpos($text,"s")) == 1 && strlen(strpos($text,"m")) == 1 && strlen(strpos($text,"h")) == 1)
        {
            $text = strtr($text,$replace);
        }
        elseif(strlen(strpos($text,"s")) == 0 && strlen(strpos($text,"m")) == 1 && strlen(strpos($text,"h")) == 1)
        {
            $text = strtr($text,$replace)."00";
        }
        elseif(strlen(strpos($text,"s")) == 0 && strlen(strpos($text,"m")) == 1 && strlen(strpos($text,"h")) == 0)
        {
            $text = "00:" . strtr($text,$replace)."00";
        }
        elseif(strlen(strpos($text,"s")) == 0 && strlen(strpos($text,"m")) == 0 && strlen(strpos($text,"h")) == 1)
        {
            $text = strtr($text,$replace)."00:00";
        }

        $text = explode(":",$text);

        return str_pad($text[0], 2, "0", STR_PAD_LEFT).":".str_pad($text[1], 2, "0", STR_PAD_LEFT).":".str_pad($text[2], 2, "0", STR_PAD_LEFT);
        
    }

}