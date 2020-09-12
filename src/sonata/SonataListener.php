<?php

declare(strict_types=1);

namespace sonata;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat as C;
use sonata\traits\TickingTrait;
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

        Sonata::getInstance()->getScheduler()->scheduleRepeatingTask(new ClosureTask(function () use($player) : void  {
            $player->sendTitle(C::ITALIC.C::GRAY."< ".C::AQUA."Sonata".C::GRAY." >");
        }),20);
    }

    public function creation(PlayerCreationEvent $event){
        $event->setPlayerClass(SonataPlayer::class);
    }
}