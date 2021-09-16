<?php

namespace AppBundle\Utils;

class TreatText
{
    /**
     * @param string $content
     * @return array|string|string[]|null
     */
    public static function onlyNumber(string $content)
    {
        return preg_replace('/[^0-9]/', '', $content);
    }
}