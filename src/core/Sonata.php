<?php

declare(strict_types=1);

namespace core;

use core\provider\ProviderManager;
use core\session\SessionManager;
use core\traits\ClassManager;
use pocketmine\plugin\PluginBase;

final class Sonata extends PluginBase
{
    use ClassManager;

    /** @var self|null  */
    static $instance = null;

    /** Random Properties */
    private $files = ["db.yml"];
    private $dir = ["gay"];

    /** Manager's Properties */
    private $providerManager;
    private $sessionManager;

    // todo Split dis and make a cool animation lel
    const NAMES = [
        "Sonata"
    ];

    public function onEnable()
    {
        $this->saveFiles();
        self::$instance = $this;
        if ($this->initiateManager()) {
            $this->getLogger()->notice("Initiated Manager(s) successfully");
            $this->getLogger()->notice("Initiated Listener(s) successfully");
        }else{
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }

    public function saveFiles() {
        foreach ($this->files as $files) {
            if (strpos($files,".") === false) {
                return;
            }
            $this->saveResource($files);
            foreach ($this->dir as $dir) {
                if (strpos($dir,"/") === false) {
                    return;
                }
                if (!is_dir($this->getDataFolder().$dir)) {
                    mkdir($this->getDataFolder().$dir);
                }
            }
        }
    }

    public function getSessionManager() : SessionManager {
        return  $this->sessionManager;
    }

    public function getProviderManager() : ProviderManager{
        return $this->providerManager;
    }

    /**
     * @param string $k
     * @param $v
     */
    public function setPropertyValue(string $k,$v) {
        $this->{$k} = $v;
    }

    static function getInstance() {
        return self::$instance;
    }
}