<?php

declare(strict_types=1);

namespace core\translation;

use pocketmine\utils\TextFormat as c;

final class Translation
{
    const MSG = [
        "noPermission" => self::RED."You have no Permission to Execute this Action!"
    ];

    const EMPTY = "‏‏‎ ‎";
    const AQUA = "§2[§bSONATA§2] §b ";
    const RED = "§4§[§cSONATA§4] §c ";

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
        if (empty($str)){
            $str = self::RED."Why i'm empty!?";
        }
        foreach ($replacement as $k => $v) {
            $str = str_replace("%$k",$v,$str);
        }
        return C::colorize($str);
    }
}