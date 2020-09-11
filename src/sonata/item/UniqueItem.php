<?php

declare(strict_types=1);

namespace sonata\item;

use pocketmine\item\Item;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\TextFormat as C;
use sonata\translation\Translation;

class UniqueItem extends Item {

    const ENTRY = "unique_item";

    private $legacy_id;

    public function __construct(string $custom_name,int $id, int $meta = 0, string $name = "Unknown",array $lore = [],array $nbt = [],string $legacy_id = null)
    {
        $this->legacy_id = $legacy_id;
        $this->setCustomName(C::RESET.$custom_name);
        $this->setLore([C::RESET.$lore.Translation::PICK_AXE]);
        foreach ($nbt as $nbts) {
            $this->getNamedTag()->setTag($nbts);
        }
        if (!$this->getNamedTag()->hasTag(self::ENTRY)) return;
        $this->getNamedTag()->setTag(new StringTag(self::ENTRY,"gay"));
        parent::__construct($id, $meta, $name);
    }

    public function getLegacyId() {
        return $this->legacy_id;
    }
}