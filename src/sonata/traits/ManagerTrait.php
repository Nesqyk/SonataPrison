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

    static $classes = [
        ItemManager::class,
        CommandManager::class
    ];

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
}