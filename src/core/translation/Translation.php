<?php

declare(strict_types=1);

namespace core\translation;

use pocketmine\utils\TextFormat as c;

final class Translation
{
    const MSG = [
        "noPermission" => self::RED."You have no Permission to Execute this Action!",
        "needMoreMoney" => self::RED."You need more "
    ];

    // Bedrock ya knoe for win10
    const PERCENTAGE = "%%%%%%%";
    // for items ya :)
    const EMPTY = "‎";
    const AQUA = "§l§b[] §7";
    const RED = "§4§[§cSONATA§4] §7 ";

    /**
     * @param string $key
     * @param array $replacement
     * @return string|null
     */
    public static function get(string $key,array $replacement= []) :?string {
        if (!isset(self::MSG[$key])) {
            throw new \InvalidArgumentException("invalid key $key");
        }
        $str = self::MSG[$key];
        if (!empty($replacement)) {
            $sub = explode("&",$str);
            $str = c::RESET.c::GRAY.$sub[1];
            foreach ($replacement as $k => $v) {
                $k  = "%".$k;
                if (strpos($k,"%") !== false) {
                    $str = str_replace($k,$v,$str);
                }
            }
        }
        return C::colorize($str);
    }
}