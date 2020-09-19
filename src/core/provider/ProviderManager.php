<?php

declare(strict_types=1);

namespace core\provider;

use core\Sonata;
use pocketmine\Player;
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
                $this->connector->waitAll();
                $this->connector->close();
            }
        }
    }

    // generic execution for databases
    public function init() : void {
        $this->connector->executeGeneric(self::P_QUERY_GENERIC);
    }

    /**
     * @param Player $player
     */
    // entry for player
    public function p_insert(Player $player) {
       $connector = $this->connector;
       if (isset($connector)) {
           $connector->executeInsert(self::P_QUERY_INSERT,["c_uuid" => $player->getUniqueId()->toString(),"c_name" => $player->getName()]);
       }
    }

    /**
     * @param Player $player Player
     * @param int $money Player's update money
     * @param int $rank Player's updated rank
     * @param int $prestige Player's updated prestige
     * @param int $mine Player's updated mine
     * @param int $scoreboard Player's update scoreboard
     * @param int $multiplier Player's updated multiplier
     */
    // did somebody said birthmark?
    public function p_change(Player $player,int $money,int $rank,int $prestige,int $mine,int $scoreboard,int $multiplier) {
        $connector = $this->connector;
        $connector->executeChange(self::P_QUERY_CHANGE,["c_money" => $money, "c_username" => $player->getName(), "c_rank" => $rank, "c_prestige" => $prestige, "c_mine" => $mine,"c_scoreboard" => $scoreboard,"c_multiplier" => $multiplier]);
    }

    /**
     * @param array $args k => v
     * @param callable|null $call callable no or yes
     */
    // did somebody said real power?
    public function p_select(array $args,?callable $call = null) {
        $connector = $this->connector;
        $connector->executeSelect(self::P_QUERY_SELECT,$args,$call);
    }


}