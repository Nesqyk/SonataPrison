<?php

declare(strict_types=1);

namespace core\provider;

use core\Sonata;
use pocketmine\Player;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

/**
 * Class ProviderManager oh yes yes
 * @package core\provider
 */
class ProviderManager
{
    private $connector;

    /** Queries for Players */
    const P_QUERY_GENERIC = "p.query.generic";
    const P_QUERY_INSERT = "p.query.insert";
    const P_QUERY_CHANGE = "p.query.change";
    const P_QUERY_SELECT = "P.query.select";

    /** Queries for Gangs */
    const G_QUERY_GENERIC = "p.query.generic";
    const G_QUERY_INSERT = "p.query.insert";
    const G_QUERY_CHANGE = "p.query.change";
    const G_QUERY_SELECT = "P.query.select";


    public function __construct(Sonata $sonata)
    {
        $parse = yaml_parse_file($sonata->getDataFolder()."db.yml");
        $this->connector = libasynql::create($sonata,$parse["database"],[
            "sqlite" => "db.sql",
            "mysql" => "db.sql"
        ]);

        // close the database
        if ($sonata->isDisabled()) {
            if (isset($this->connector)) {
                $this->getConnector()->waitAll();
                $this->getConnector()->close();
            }
        }
    }

    // generic execution for databases
    public function init() : void {
        $this->getConnector()->executeGeneric(self::P_QUERY_GENERIC);
    }

    /**
     * @param string $uuid player's uuid
     * @param string $username player's username
     */
    // i could've change the param into Player but no
    public static function p_insert(string $uuid,string $username) {
       $connector = self::getConnector();
       if (isset($connector)) {
           $connector->executeInsert(self::P_QUERY_INSERT,["uuid" => $uuid,"name" => $username]);
       }
    }

    /**
     * @param Player $player Player
     * @param int $money Player's update money
     * @param int $rank Player's updated rank
     * @param int $prestige Player's updated prestige
     * @param int $mine Player's updated mine
     * @param int $scoreboard Player's update scoreboard
     */
    // did somebody said birthmark?
    public static function p_change(Player $player,int $money,int $rank,int $prestige,int $mine,int $scoreboard) {
        $connector = self::getConnector();
        $connector->executeChange(self::P_QUERY_CHANGE,["c_money" => $money, "c_username" => $player->getName(), "c_rank" => $rank, "c_prestige" => $prestige, "c_mine" => $mine,"c_scoreboard" => $scoreboard]);
    }

    /**
     * @param array $args k => v
     * @param callable|null $call callable no or yes
     */
    // did somebody said real power?
    public static function p_select(array $args,?callable $call = null) {
        $connector = self::getConnector();
        $connector->executeSelect(self::P_QUERY_SELECT,$args,$call);
    }

    public static function getConnector() : DataConnector {
        return  (new self)->connector;
    }
}