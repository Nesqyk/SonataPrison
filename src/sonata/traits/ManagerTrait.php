<?php

namespace sonata\traits;

/**
 * Trait ManagerTrait
 * @package sonata\traits
 */
trait ManagerTrait {

    static $classes = [

    ];

    public function initiate() : bool {
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