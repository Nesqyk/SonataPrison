<?php

namespace sonata\item\unique;


use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\TextFormat as C;
use sonata\item\UniqueItem;

class Dynamite extends UniqueItem
{
    const RARE = [
      "size" => [
          1 => 1,
          2 => 3
      ]
    ];

    const DYNAMITE_ENTRY = "dynamyto_entry";
    const DYNAMITE_SIZE = "dynamyto_sizeo";

    public function __construct(int $dynamite_id)
    {
        if (!isset(self::RARE["size"][$dynamite_id])) return;

        $custom_name = C::RED."Dynamite";
        $nbt = [new StringTag(self::DYNAMITE_ENTRY,"gay"),new IntTag(self::DYNAMITE_SIZE,self::RARE["size"][$dynamite_id])];
        $lore = [];
        $lore[] = C::GRAY."A Throwable item used to break blocks";
        $lore[] = C::GRAY."";
        $lore[] = c::BOLD.C::RED."Information";
        $lore[] = c::GRAY."   Explosion Size ".c::BOLD.c::RED.self::RARE["size"][$dynamite_id];

        parent::__construct($custom_name, self::TNT, 0, "Dynamite", $lore,$nbt);
    }
}