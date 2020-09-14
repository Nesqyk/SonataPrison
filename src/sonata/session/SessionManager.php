<?php

declare(strict_types=1);

namespace sonata\session;

use pocketmine\Player;
use sonata\Sonata;

class SessionManager
{
    private $p_session = [];

    /**
     * SessionManager constructor.
     * @param Sonata $sonata
     */
    public function __construct(Sonata $sonata)
    {

    }

    public function create(Player $player) {
        if (!empty($this->p_session)) {

            if (isset($this->p_session[$player->getName()])) {
                $this->load($player);
            }
            $session = "";
            $this->p_session[$player->getName()];
            Sonata::getInstance()->getLogger()->notice("creating session for '{$player->getName()}'");
            return;
        }
    }

    public function load(Player $player) {
        Sonata::getInstance()->getLogger()->notice("loading session for '{$player->getName()}'");
    }

    /**
     * @param Player $player
     * @return SessionPlayer|null
     */
    public function get(Player $player) : ?SessionPlayer {
        $session = null;

        if (isset($this->p_session[$player->getName()])) {
            $session = $this->p_session[$player->getName()];
        }
        return $session;
    }
}