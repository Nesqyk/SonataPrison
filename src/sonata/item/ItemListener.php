<?php

declare(strict_types=1);

namespace sonata\item;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class ItemListener implements Listener
{
    private $dynamite = [];

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $nametag = $item->getNamedTag();

        if (!$nametag->hasTag(UniqueItem::ENTRY)) return;

        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {

        }
    }


}