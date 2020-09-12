<?php

declare(strict_types=1);

namespace sonata;

use pocketmine\Player;
use sonata\utils\DatabaseQuery;

class SonataPlayer extends Player implements DatabaseQuery
{
    public function getScoreboard() : int {

    }
}