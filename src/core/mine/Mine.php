<?php

declare(strict_types=1);

namespace core\mine;

use pocketmine\scheduler\Task;

abstract class Mine extends Task
{
    public function __construct(string $name,string $level,array $pos1,array $pos2)
    {

    }
}