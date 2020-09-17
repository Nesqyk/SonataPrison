<?php

declare(strict_types=1);

namespace core\utils;

final class Utils
{
    /**
     * @param $value
     * @return string
     */
    static function convertToThPlace($value) {
        $return = "";
        if ($value < 1000) {
            $parts = ["K","M","B","T"];
            $real = explode(",",round($value));
            $return = $real[0].$real[0][1] !== 0? ".".$real[0][1] : " ";
            $return .= $parts[count($parts) - 1] - 1;
        }
        return $return;
    }
}