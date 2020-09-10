<?php

namespace sonata;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat as C;
use sonata\translation\Translation;

class SonataListener implements Listener
{
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        if (!$player->hasPlayedBefore()) {
            $event->setJoinMessage(Translation::getMessage("playerJoined",[
                "player" => $player->getName()
            ]));
        }
        $event->setJoinMessage(Translation::getMessage("playerFirstJoin",[
            "player" => $player->getName()
        ]));

        Sonata::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use($player) : void  {
            $player->sendTitle(C::ITALIC.C::GRAY."< ".C::AQUA."Sonata".C::GRAY." >");
        }),20);
    }
}