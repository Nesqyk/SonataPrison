<?php

declare(strict_types=1);


namespace sonata;

use pocketmine\plugin\PluginBase;
use sonata\traits\ManagerTrait;

class Sonata extends PluginBase {
    use ManagerTrait;

    /** @var self */
    protected static $instance;

    /** @var array  */
    private const files = ["changelog.yml"];

    /** @var array  */
    private const dir = [];

    public function onEnable()
    {
        $this->initiate_all();
        self::$instance = $this;
        $this->save_file();
    }

    /**
     * @return bool
     */
    public function initiate_listener() : bool {
        try {
            $this->getServer()->getPluginManager()->registerEvents(new SonataListener(),$this);
        }catch (\Exception $exception) {
            $this->getLogger()->notice("Failed to initiate {$exception->getFile()} :".$exception->getTraceAsString());
            return  false;
        }
        return  true;
    }

    public function initiate_all() {
        if (!$this->initiateManager() || !$this->initiate_listener()) {
            $this->getServer()->shutdown();
        }

        $this->getLogger()->notice("Initiating All Stuffs");
        usleep(2000);
        $this->getLogger()->notice("Initiating Listener(s) was Successful");
        $this->initiate_listener();
        usleep(2000);
        $this->getLogger()->notice("Initiating Manager(s) was Successful");
        $this->initiateManager();
    }

    public function save_file() {
        foreach (self::dir as $dir) {
            if (!is_dir($this->getDataFolder().$dir)) return;
            $dirr =  explode("/",$dir);
            if ($dirr != null) {
                mkdir($this->getDataFolder().$dir);
            }

            foreach (self::files as $file) {
                $extension = explode(".",$file);
                if ($extension == null) {
                    throw new \InvalidArgumentException("invalid file extension on null");
                }
                $this->saveResource($file);
            }
        }
    }

    /**
     * @param string $name
     * @param $class
     */
    private function setManager(string $name,$class) {
        $this->{$name} = $class;
    }

    public static function getInstance() {
        return self::$instance;
    }
}