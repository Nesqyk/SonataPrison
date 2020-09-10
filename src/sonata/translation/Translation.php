<?php

namespace sonata\translation;


use pocketmine\utils\TextFormat;

final class Translation {

    const KEYS = [
        "playerJoined" => "&1> &b%player",
        "playerFirstJoin" => "&1>^ &b%player",
        "playerQuits" => "&4> &c%player"
    ];


    const EC_RED = "§8<§c§l!§r§8> §r§7 ";
    const EC_GREEN = "§8<§a§l!§r§8> §r§7 ";
    const EC_AQUA = "§8<§b§l!§r§8> §r§7 ";
    const EC_WHITE= "§8<§f§l!§r§8> §r§7 ";

    /**
     * @param string $k
     * @param array $r
     * @return string|null
     */
    public static function getMessage(string $k,array $r = []) : ?string {
        if (!isset(self::KEYS[$k])) {
            throw new \InvalidArgumentException("key $k doesn't exist.");
        }

        $str = base64_decode(self::KEYS[$k]) == true ? TextFormat::colorize(base64_decode(self::KEYS[$k])) : TextFormat::colorize(self::KEYS[$k]);
        foreach ($r as $key => $value) {
            $str = str_replace("%".$key,$value,$str);
        }

        return $str;
    }

}