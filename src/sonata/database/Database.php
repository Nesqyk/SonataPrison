<?php

namespace sonata\database;


use libs\libasynql\DataConnector;
use libs\libasynql\libasynql;
use pocketmine\level\generator\object\BirchTree;
use sonata\Sonata;

class Database implements DatabaseQuery
{
    const ALL_P_QUERIES = [
      self::P_UPDATE,
      self::P_SELECT,
      self::P_SELECT,
      self::P_GENERIC
    ];
    
    /** @var DataConnector  */
    public $data;

    /**
     * Database constructor.
     * @param Sonata $sonata plugin param fuck off
     * @todo Change it to mysql in release
     * @todo Add a async query on it / ima probably uses awaitgen
     */
    public function __construct(Sonata $sonata)
    {
        $parse = json_decode((string)$this->jsonSerialize(),true);
        $this->data = libasynql::create($sonata,$parse["database"],[
           "sqlite" => "Database.sql"
        ]);
    }

    public function init() : void {
        $this->data->executeGeneric(self::P_GENERIC);
    }

    public static function getConnector() : DataConnector
    {
        return (new self)->data;
    }

    /**
     * @param array $args
     * @param callable|null $call
     */
    public static function insert(array $args,?callable $call = null) {
        self::getConnector()->executeInsert(self::P_INSERT,$args,$call);
    }

    /**
     * @param array $args
     */
    public static function select(array $args) {
        self::getConnector()->executeSelect(self::P_SELECT,$args);
    }

    /**
     * @param array $args
     */
    public static function change(array $args) {
        self::getConnector()->executeChange(self::P_UPDATE,$args);
    }

    public function jsonSerialize() {
        return [
            "database" => [
                "type" => "sqlite" , // type
                "sqlite" => [
                    "file" => Sonata::getInstance()->getDataFolder()."database/Database.sql" // path
                ],"mysql" => [
                    "host" => '127.0.0.1', // mysql host
                    "username" => 'root', // username
                    "password" => '',
                    "schema" => 'your schema'
                ],
                "work-limit" => 1 // 1 for sqlite and 2  for mysql
            ]
        ];
    }
}