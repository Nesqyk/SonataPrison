<?php

declare(strict_types=1);

namespace sonata\session;

use pocketmine\Player;
use sonata\database\Database;

class SessionPlayer
{
    private $player;

    private $money;
    private $mine;
    private $prestige;
    private $scoreboard;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->initiate();
    }

    public function initiate() {
        Database::insert([
            "uname" => $this->player->getName(),
            "uuid" => $this->player->getUniqueId()->toString(),
        ]);
    }

    public function getMoney() {
        return $this->money;
    }

    public function getPrestige() {
        return $this->prestige;
    }

    public function getMine() {

    }

    public function change() {
        Database::change([
           ""
        ]);
    }
}