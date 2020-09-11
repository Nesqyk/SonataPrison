<?php

declare(strict_types=1);

namespace sonata\item;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use sonata\item\unique\Dynamite;
use sonata\translation\Translation;

class ItemListener implements Listener
{
    private $dynamite = [];

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $nametag = $item->getNamedTag();

        if (!$nametag->hasTag(UniqueItem::ENTRY)) return;

        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
            if ($nametag->hasTag(Dynamite::DYNAMITE_ENTRY)) {
                $size = $nametag->getInt(Dynamite::DYNAMITE_SIZE);
                if ($size !== 0) {
                    $item->pop();

                    $directional = $player->getDirectionVector();
                    if (!isset($this->dynamite[$player->getRawUniqueId()])) {
                        $this->dynamite[$player->getRawUniqueId()] = time();
                    }
                    if (time() - $this->dynamite[$player->getRawUniqueId()] <= 0) {
                        $explosion = new Explosion(new Position($directional->asVector3()->add(0,1.3,0)),$size);
                        $explosion->explodeB();
                        $player->getLevel()->dropItem($player->add(0,1.3,0),Item::get(Item::TNT,0,1),$directional->multiply(0.4),40);
                        $this->dynamite[$player->getRawUniqueId()] = time();
                    }
                    $player->sendMessage(Translation::getMessage("dynamiteProcess",[
                        "time" => 5 - (time() - $this->dynamite[$player->getRawUniqueId()])
                    ]));
                    $event->setCancelled();
                }
            }
        }
    }
}