<?php

declare(strict_types=1);

namespace core\session;

use core\session\sort\PlayerSession;
use core\Sonata;
use pocketmine\Player;

class SessionManager
{
    /** @var array */
    private $players = [];

    /** @var Sonata */
    private $sonata;

    public function __construct(Sonata $sonata)
    {
        $this->sonata = $sonata;
    }

    /**
     * @param Player $player player param yes
     */
    public function create(Player $player)
    {
        if (!isset($this->players[$player->getName()])) {
            $this->players[$player->getName()] = new PlayerSession($player);
            $this->sonata->getLogger()->notice("creating session for {$player->getName()}");
        }
    }

    /**
     * @param Player $player
     * @return PlayerSession|null
     */
    public function get(Player $player): ?PlayerSession
    {
        $session = $this->players[$player->getName()];
        if (!isset($session)) {
            $this->create($player);
        }
        return $session;
    }
}