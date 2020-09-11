<?php

namespace sonata\traits;


use pocketmine\Player;

trait TickingTrait
{
    /** @var array  */
    private $tick = [];
    private $time;

    public function get(Player $player) : int {
        if (!isset($this->tick[$player->getRawUniqueId()])) {
            $this->tick[$player->getRawUniqueId()] = time();
        }
        if (time() - $this->tick[$player->getRawUniqueId()] < 0) {
            $this->tick[$player->getRawUniqueId()] = time();
        }
        return $this->time - (time() - $this->tick[$player->getRawUniqueId()]);
    }
}