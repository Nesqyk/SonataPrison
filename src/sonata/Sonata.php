<?php

declare(strict_types=1);


namespace sonata;

use pocketmine\plugin\PluginBase;
use sonata\traits\ManagerTrait;

/**
 * Class Sonata
 * @package sonata
 */
class Sonata extends PluginBase {
    use ManagerTrait;

    /** @var self */
    protected static $instance;

    /** @var array */
    private $files = ["changelog.yml"];

    public function onEnable()
    {
        if ($this->initiate() === true) {
            $this->getLogger()->notice("Initiating Managers was Successful ");
        }else{
            $this->getServer()->shutdown();
        }
        foreach ($this->files as $file) {
            $this->saveResource($file);
        }
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new SonataListener(),$this);
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