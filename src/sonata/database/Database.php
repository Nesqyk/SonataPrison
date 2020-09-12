<?php

declare(strict_types=1);


namespace sonata\database;

use libs\libasynql\libasynql;
use sonata\Sonata;
use sonata\SonataPlayer;
use sonata\utils\DatabaseQuery;

class Database implements DatabaseQuery
{
    public $data;
    public $sessions = [];

    public function __construct(Sonata $sonata)
    {
        $encode = yaml_parse_file($sonata->getDataFolder()."/database/database.yml");
        $this->data = libasynql::create($sonata,$encode["data"],[
            "sqlite" => "/database/Database.sql"
        ]);
        $this->init();
    }

    public function init() {
        $this->data->executeGeneric(self::P_GENERIC);
    }

}