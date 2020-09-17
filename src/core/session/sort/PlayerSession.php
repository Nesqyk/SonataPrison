<?php

declare(strict_types=1);

namespace core\session\sort;

use core\provider\ProviderManager;
use core\utils\Utils;
use pocketmine\Player;

/**
 * Class PlayerSession
 * @package core\session\sort
 */
class PlayerSession
{
    /** @var Player  */
    private $player;

    /** @var int */
    private $money;

    /** @var int */
    private $mine;

    /** @var int */
    private $prestige;

    /** @var int */
    private $rank_id;

    /** @var int */
    private $scoreboard;

    /** @var array  */
    static $RANK_ID_STRING = [
      0 => "In-mate",
      1 => "Prisoner"
    ];

    public function __construct(Player $player)
    {
        $this->initiate();
        $this->player = $player;
    }

    public function getPlayer() {
        return $this->player;
    }

    /**
     * @param bool $th_place to string or no
     * @return int|string returns rank id | thousand place
     */
    public function getMoney(bool $th_place = false) {
       if ($th_place) {
           return $this->money;
       }
       return Utils::convertToThPlace($this->money);
    }

    /**
     * @param bool $to_string to string true | false
     * @return int|mixed returns rank id | string
     */
    public function getRankId(bool $to_string = false) {
        if ($to_string) {
            return $this->rank_id;
        }
        return self::$RANK_ID_STRING[$this->rank_id];
    }


    public function getPrestige() {
        return $this->prestige;
    }

    public function getScoreboard() {
        return $this->prestige;
    }

    /**
     * @param bool $to_string To string true | false
     * @return int|string returns mine number | string
     */
    public function getMine(bool $to_string = false) {
        if ($to_string) {
            return $this->mine;
        }
        return $this->convertToLetter($this->mine);
    }

    /**
     * @param int $number mine number
     * @return string returns to a letter UPPERCASE
     */
    public function convertToLetter(int $number) {
        $letters = range('a','z');
        $string = "";
        if (isset($letters[$number])) {
            $string = $letters[$number];
            if ($number === 27) {
                $string = 'free';
            }
        }
        return strtoupper($string);
    }

    public function getChatFormat() {

    }

    // initiate player like insert em yea register it.
    public function initiate() {
        ProviderManager::p_insert($this->player->getUniqueId()->toString(),$this->player->getName());
    }

    // chane the player things yea.
    public function update() {
        ProviderManager::p_change($this->getPlayer(),$this->getMoney(),$this->getRankId(),$this->getPrestige(),$this->getMine(),$this->getScoreboard());
    }
}