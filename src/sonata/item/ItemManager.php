<?php

declare(strict_types=1);

namespace sonata\item;


use pocketmine\item\ItemFactory;
use sonata\Sonata;

class ItemManager
{
    private $items = [];

    public function __construct(Sonata $sonata)
    {
        $sonata->getServer()->getPluginManager()->registerEvents(new ItemListener(),$sonata);
        $this->init();
    }

    public function init() {

    }

    /**
     * @param UniqueItem $item
     * @param bool $force
     * @todo idk lol
     */
    public function registerItem(UniqueItem $item,bool $force =false) {
        if (isset($this->items[$item->getLegacyId()]) || ItemFactory::isRegistered($item->getId())) {
            throw new \InvalidArgumentException("$item legacy id is already registered");
        }

        $this->items[$item->getLegacyId()] = $item->getId();
        ItemFactory::registerItem($item,$force);
    }
}