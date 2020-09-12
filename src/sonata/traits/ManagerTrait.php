<?php

declare(strict_types=1);

namespace sonata\traits;

use sonata\command\CommandManager;
use sonata\item\ItemManager;

/**
 * Trait ManagerTrait
 * @package sonata\traits
 */
trait ManagerTrait {

    private static $classes = [
        ItemManager::class,
        CommandManager::class
    ];

    private static $glob = [];

    public function initiateManager() : bool {
        foreach (self::$classes as $class) {
            $base = strtolower(basename($class));
            $class_name = trim($base,"manager");
            try {
                $class_name .= "Manager";
                $this->setManager($class_name,new $class($this));
            }catch (\Exception $exception) {
                $this->getLogger()->warning("while initiating $class a error popped {$exception->getFile()}".$exception->getMessage());
                return  false;
            }
        }
        return true;
    }

    public function initiateGlob() : bool
    {
        if (!empty(self::$glob)) {
            foreach (self::$glob as $glob_class) {
                $glob_name = strtolower(trim(basename($glob_class), "\t\n\r\0\x0B"));
                try {
                    $this->{$glob_name} = new $glob_name($this);
                } catch (\Exception $exception) {
                    $this->getLogger()->warning("white initiating glob {$exception->getFile()} a error popped {$exception->getTraceAsString()}");
                    return  false;
                }
            }
        }
        return  true;
    }
}