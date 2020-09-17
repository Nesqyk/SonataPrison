<?php

namespace core\session\sort;

use core\provider\ProviderManager;
use core\traits\SonataInstance;
use core\utils\Utils;
use Exception;
use pocketmine\Player;

/**
 * Class PlayerSession
 * @package core\session\sort
 */
class PlayerSession
{
    use SonataInstance;

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

    /** @var int */
    private $booster;

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
           return floatval($this->money);
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
            $string = $number === 27 ? 'free' : $string;
        }
        return strtoupper($string);
    }

    public function getChatFormat() {

    }


    /**
     * @param bool $to_string
     * @return false|float|string
     */
    public function getBooster(bool $to_string = false) {
        $format =  number_format($this->booster,0,"."," ");
        if ($to_string) {
            $format= round($this->booster,2);
            return  $format;
        }
        $format .= 'x';
        return $format;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getFirstJoinString() : string {
        $time_stamp = $this->getPlayer()->getFirstPlayed() - microtime() * 1/1000;
        $date = new \DateTime();
        $date->setTimestamp($time_stamp);
        return $date->format(DATE_RFC3339_EXTENDED);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getLastSeenString() : string  {
        $time_stamp = $this->getPlayer()->getLastPlayed() - microtime() * 1/1000;
        $date = new \DateTime();
        $date->setTimestamp($time_stamp);
        $last_seen = "Now!";

        // Conditional :rolling_eyes:
        if ($date->format("d") === 365) {
            // F man
            $last_seen = $date->format(DATE_RFC3339_EXTENDED);
        }
        if ($date->format("d") !== 365) {
            $last_seen = $date->format("d")."day(s) ago";
        }
        if ($date->format("i") >= 60) {
            $last_seen = $date->format("i")." minute(s) ago";
        }
        if ($date->format("h") <= 24) {
            $last_seen = $date->format("H")." hour(s) ago";
        }

        return $last_seen;
    }

    // initiate player like insert em yea register it.
    public function initiate() {
        $this->provider()->p_insert($this->player->getUniqueId()->toString(),$this->player->getUniqueId()->toString());
    }

    // chane the player things yea.
    public function update() {
        $this->provider()->p_change($this->getPlayer(),$this->getMoney(),$this->getRankId(),$this->getPrestige(),$this->getMine(),$this->getScoreboard(),$this->getBooster());
    }
}