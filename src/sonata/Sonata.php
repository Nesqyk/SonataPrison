<?php

declare(strict_types=1);

namespace sonata;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as C;
use ReflectionException;
use sonata\database\Database;
use sonata\traits\ManagerTrait;

class Sonata extends PluginBase
{
    use ManagerTrait;

    /** @var array  */
    private $files = [];

    /** @var array  */
    private $dir = ["database/"];

    /** @var Database */
    private $database;

    public function onEnable()
    {
        $this->initiateAll();
    }

    public function initiateAll() {
        if ($this->initiateFiles() || $this->initiateManagers()) {
            $this->getLogger()->info("Initiated Managers");
            $this->getLogger()->info("Initiated Files");

            $this->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {

                public $PREFIX = "§o§b Sonata Prison :§r ";

                private $sonata;

                public function __construct(Sonata $sonata)
                {
                    $this->sonata = $sonata;
                }

                public function onRun(int $currentTick)
                {
                    $random = ['b','2',9];
                    $message = ['Prestige !','Gangs !','and Much more!'];
                    $messages = $this->PREFIX.c::ESCAPE.$random[array_rand($random)].$message[array_rand($message)];
                    $this->sonata->getServer()->getNetwork()->setName($messages);
                }
            },20);
        }else{
            $this->getServer()->shutdown();
        }
    }


    /**
     * @param $class
     * @return bool
     * @throws ReflectionException
     */
    // don't use dis if not actually need
    static function debug($class) {
        $reflection = new \ReflectionClass($class);
        $debug = false;
        (new self)->getLogger()->info("Debugging ".basename($class)."...");

        if ($debug) {
            $debug_M = var_dump($class,$reflection->getEndLine(),$_REQUEST);
            (new self)->getLogger()->info("debugged ".basename($class).$debug_M);
            $debug = true;
        }
        return $debug;
    }

    public function getDatabase() : Database {
        return  $this->database;
    }

    /**
     * @return bool
     */
    public function initiateFiles() : bool {
        foreach ($this->files as $file) {
            foreach ($this->dir as $dir) {
                if (strpos($file,'.') === false || strpos($dir,'/') === false){
                    return false;
                }
                $this->saveResource($file);
                if (!is_dir($this->getDataFolder().$dir)) {
                    mkdir($this->getDataFolder().$dir);
                }
            }
        }
        return true;
    }

    /**
     * @return Sonata|null
     */
    public static function getInstance() : self {
        $instance = null;
        if ($instance) {
            $instance = new self;
        }
        return $instance;
    }
}