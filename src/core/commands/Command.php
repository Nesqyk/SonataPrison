<?php

declare(strict_types=1);

namespace core\commands;

use core\traits\SonataInstance;
use core\translation\Translation;
use pocketmine\command\CommandSender;

abstract class Command extends \pocketmine\command\Command
{
    use SonataInstance;

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $param
     */
    // change it to param ,Reason : g isn't working and h  too
    abstract function execute(CommandSender $sender, string $commandLabel, array $param) : void;

    /**
     * @param string $k
     * @param array $r
     */
    function get(string $k,array $r = []) {
        Translation::get($k,$r);
    }
}