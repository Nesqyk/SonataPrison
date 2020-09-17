<?php

declare(strict_types=1);

namespace core;

use core\provider\ProviderManager;
use core\traits\ManagerTrait;
use pocketmine\plugin\PluginBase;

final class Sonata extends PluginBase
{
    use ManagerTrait;

    /** @var self|null  */
    static $instance = null;

    private $files = ["db.yml"];
    private $dir = [];

    private $providerManager;

    const NAMES = [

    ];

    public function onEnable()
    {
        $this->initializeManager();
        $this->saveFiles();
        self::$instance = $this;
    }

    public function saveFiles() {
        foreach ($this->files as $files) {
            $this->saveResource($files);
            foreach ($this->dir as $dir) {
                mkdir($this->getDataFolder().$dir);
            }
        }
    }

    public function getProviderManager() : ProviderManager{
        return $this->providerManager;
    }

    static function getInstance() {
        return self::$instance;
    }
}