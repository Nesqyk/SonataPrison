<?php

declare(strict_types=1);

namespace core\traits;

use core\commands\CommandManager;
use core\provider\ProviderManager;
use core\session\SessionManager;
use core\SonataListener;
use Exception;
use pocketmine\event\Listener;

trait ClassManager
{
    use SonataInstance;

    /** Managers */
    private static $MANAGERS = [
        ProviderManager::class,
        SessionManager::class,
        CommandManager::class
    ];

    /** Listeners */
    private static $LISTENERS = [
        SonataListener::class
    ];

    private static $RANDOM = [

    ];

    /**
     * @return bool
     */
    public function initiateManager() : bool
    {
        foreach (self::$LISTENERS as $listeners) {
            foreach (self::$MANAGERS as $class_name) {
                // if there's a long way there's a short way to - ling ling 40 hours
                $base_name = strtolower(basename($class_name));
                $base_name = explode("manager",$base_name);
                $base_name = $base_name[0]."Manager";

                if (!is_a($listeners,Listener::class,true)) {
                    throw new \InvalidArgumentException("$listeners isn't a Listener!");
                }
                try {
                    $this->instance()->getServer()->getPluginManager()->registerEvents(new $listeners,$this->instance());
                    $this->setPropertyValue($base_name, new $class_name($this));
                } catch (Exception $exception) {
                    $this->getLogger()->warning("failed to initiate {$exception->getFile()}  : {$exception->getMessage()}");
                    return false;
                }
            }
        }
        return true;
    }
}