<?php

declare(strict_types=1);

namespace sonata\translation;

use pocketmine\utils\TextFormat;

final class Translation {

    const KEYS = [
        "playerJoined" => "&1> &b%player",
        "playerFirstJoin" => "&1>^ &b%player",
        "playerQuits" => "&4> &c%player",
        "commandProcess" => self::EC_RED."Wait till %item before executing a command",
        "noPerm" => self::EC_RED."You don't have permission to execute this! ",
        "nullPlayer" => self::EC_RED."That player is isn't Online or you just misspelled it!",
        "itemGiven" => self::EC_GREEN."You have been given a &r%item&7 x%count",
        "itemGive" => self::EC_GREEN."You gave %player a &r%item&7 x%count",
        "invalidInt" => self::EC_RED."Argument given isn't a Int!",
        "dynamiteProcess" => self::EC_RED."You can throw a dynamite again after %item"
    ];


    const PICK_AXE = "⛏";
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

        $str = base64_decode(self::KEYS[$k]) == null ? TextFormat::colorize(base64_decode(self::KEYS[$k])) : TextFormat::colorize(self::KEYS[$k]);
        foreach ($r as $key => $value) {
            $str = str_replace("%".$key,$value,$str);
        }

        return $str;
    }

}