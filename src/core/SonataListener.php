<?php

declare(strict_types=1);

namespace core;

use core\traits\SonataInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\QueryRegenerateEvent;

class SonataListener implements Listener
{
    use SonataInstance;

    /**
     * @priority HIGHEST
     * @param PlayerPreLoginEvent $event
     */
    public function onPreLogin(PlayerPreLoginEvent $event) {
        $player = $event->getPlayer();
        $this->session()->create($player);
    }

    public function PlayerJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
    }

    public function query(QueryRegenerateEvent $event) {
        $event->setMaxPlayerCount(1);
        if ($event instanceof PlayerJoinEvent) {
            $event->setMaxPlayerCount($event->getMaxPlayerCount() + 1);
        }
        if ($event instanceof PlayerQuitEvent) {
            $event->setMaxPlayerCount($event->getMaxPlayerCount() - 1);
        }
    }
}
