<?php

namespace core\session\sort;

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
    private $multiplier;

    /** @var array  */
    static $RANK_ID_STRING = [
      0 => "In-mate",
      1 => "Prisoner"
    ];

    public function __construct(Player $player)
    {
        $this->player = $player;
        // put this always at last or else null :|
        $this->initiate();
    }

    public function getPlayer() {
        return $this->player;
    }

    public function setMine(int $mine) {
        $this->mine += $mine;
    }

    /**
     * @return int player`s money
     */
    public function getMoney() {
       return  $this->money;
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

    // 24,000,000
    public function getPrice(int $mine) {
        $range = range(1,27);
        $slice = range(1,24000000);
        asort($slice);
        for ($i = 1 ; $i < 24000000; $i ++) {
            $range[] = array_slice($slice,$i);
        }
        return $range[$mine];
    }

    /**
     * lol
     * @param $int
     */
    public function rankUp($int) {
        $this->mine += $int;
    }

    /**
     * @return int|mixed|string|null
     */
    public function getCurrentRemaining() {
        return isset(self::$MINE_PRICES[$this->mine]) ? self::$MINE_PRICES[$this->mine] - $this->getMoney(): null;
    }

    /**
     * @return mixed|null
     */
    public function getCurrentNeeded() {
        return isset(self::$MINE_PRICES[$this->mine]) ? self::$MINE_PRICES[$this->mine] : null;
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


    /**
     * @param bool $to_string
     * @return false|float|string
     */
    public function getMultiplier(bool $to_string = false) {
        $format =  number_format($this->multiplier,0,"."," ");
        if ($to_string) {
            $format= round($this->multiplier,2);
        }
        $format .= 'x';
        return $format;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getFirstJoinString() : string {
        $time_stamp = $this->getPlayer()->getFirstPlayed() - 1400 * 1/1000;
        $date = new \DateTime();
        $date->setTimestamp($time_stamp);
        return $date->format(DATE_RFC3339_EXTENDED);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getLastSeenString() : string  {
        $time_stamp = $this->getPlayer()->getLastPlayed() - 1400 * 1/1000;
        $date = new \DateTime();
        $date->setTimestamp($time_stamp);
        $last_seen = "Now!";

        // Conditional :rolling_eyes:
        if ($date->format("d") === 365) {
            // F man
            $last_seen = $date->format(DATE_RFC3339_EXTENDED);
        }
        if ($date->format("d") >= 365) {
            $last_seen = $date->format("d")."day(s) ago";
        }
        if ($date->format("i") >= 60) {
            $last_seen = $date->format("i")." minute(s) ago";
        }
        if ($date->format("h") >= 24) {
            $last_seen = $date->format("H")." hour(s) ago";
        }

        return $last_seen;
    }

    // initiate player like insert em yea register it.
    public function initiate() {
        $this->provider()->p_insert($this->getPlayer());
    }

    // chane the player things yea.
    public function update() {
        $this->provider()->p_change($this->getPlayer(),$this->getMoney(),$this->getRankId(),$this->getPrestige(),$this->getMine(),$this->getScoreboard(),$this->getMultiplier());
    }

    public function jsonSerialize() {
        return [
            "money" => Utils::convertToThPlace($this->money),
        ];
    }
}