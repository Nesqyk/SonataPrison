<?php

declare(strict_types=1);

namespace sonata\session;

use pocketmine\utils\TextFormat as C;

class PlayerSession
{
    private $uuid;
    private $username;
    private $mine;
    private $prestige;
    private $money;

    public static $mines = [
        'a' => 30000,
        'b' => 100000,
        'c' => 220000,
    ];

    public function __construct(string $uuid,string $username,string $mine,int $prestige,int $money)
    {
        $this->uuid= $uuid;
        $this->username= $username;
        $this->mine= $mine;
        $this->prestige= $prestige;
        $this->money= $money;
        self::$mines = range('a','z');
    }

    public function getUUID() {
        return $this->uuid;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getMine() {
        return $this->mine;
    }

    public function getPrestige() {
        return $this->prestige;
    }

    public function getMoney() {
        return $this->money;
    }

    public function setMoney(int $money) {
        $this->money = $money;
    }

    public function addMoney(int $money) {
        $this->money += $money;
    }

    /**
     * @return string
     */
    public function setNextMine() {
        $pos = array_search($this->mine,array_keys(self::$mines));
        return isset($pos[$pos + 1]) ? $this->mine = $pos[$pos + 1] : 'a';
    }

    /**
     * @param bool $price
     * @return float|int|mixed|string
     */
    public function getNextMine(bool $price = true) {
        if ($price) {
            $pos = array_search($this->mine,array_keys(self::$mines));
            return isset($pos[$pos + 1]) ? self::$mines[$pos + 1] * $this->getPrestige() : self::$mines['a'];
        }
        $pos = array_search($this->mine,array_keys(self::$mines));
        return isset($pos[$pos + 1]) ?  $pos[$pos + 1]: 'a';
    }

    /**
     * @param bool $price
     * @return float|int|string
     */
    public function getCurrentMine(bool $price = true) {
        if ($price) {
            return self::$mines[$this->getMine()] * $this->getPrestige();
        }
        return strtoupper($this->getMine());
    }

    /**
     * @return bool
     */
    public function canRank_up() : bool {
        if (self::$mines[$this->getMine()] * $this->getPrestige() < $this->getMoney()) {
            return  true;
        }
        return false;
    }

    public function rank_up_bar()
    {
        $uni = ":";
        $repeat = 50;

        switch ($this->getPrestige()) {
            case $this->getPrestige() < 100:
                $uni = "▇";
                $repeat -= 40;
                break;

            case 20:
                $repeat -= 5;
                break;
        }
    }
}