<?php

declare(strict_types=1);

namespace sonata;

use pocketmine\Player;
use sonata\database\Database;

class SonataPlayer extends Player
{
    public function addMoney(int $amount) {
        $currents = ["money" => $amount];
        Database::getInstance()->update($this,$currents);
    }
}