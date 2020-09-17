<?php

declare(strict_types=1);

namespace core\traits;

use core\provider\ProviderManager;

trait ManagerTrait
{
    static $MANAGERS = [
        ProviderManager::class
    ];

    static $GLOB = [

    ];

    final function initializeManager()
    {
        foreach (self::$MANAGERS as $class) {
            $class_name = strtolower(trim(basename($class), "Manager")) . "Manager";
            try {
                $this->setPropertyValue($class_name, new $class($this));
            } catch (\Exception $exception) {
                $this->getLogger()->warning("failed to initialize {$exception->getFile()} : {$exception->getTraceAsString()}");
            }
        }
    }


    /**
     * @param string $name property name
     * @param object $class property class value
     */
    final function setPropertyValue(string $name,object $class) {
        $this->{$name} = $class;
    }
}