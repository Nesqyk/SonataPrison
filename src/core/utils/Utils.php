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

    /**
     * @param int $time
     * @return mixed
     */
    static function convertMilitaryToDefault(int $time) {
        $format = [];
        for ($ii = 13; $ii < 24; $ii ++) {
            for ($i = 1;$i < 12;$i ++) {
                $format = array($ii => $i);
            }
        }
        return $format[$time];
    }

    /**
     * @param int $time
     * @return string
     */
    static function convertToAmPm(int $time) {
        $am = range(1,12);
        $pm = range(13,24);
        return $am[$time] !== $pm[$time] ? "AM" : "PM";
    }
}