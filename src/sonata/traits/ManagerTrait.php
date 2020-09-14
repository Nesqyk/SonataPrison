<?php

declare(strict_types=1);

namespace sonata\traits;

use sonata\database\Database;

trait ManagerTrait
{
    /** @var array  */
    private static $class = [

    ];

    /** @var array  */
    private static $glob = [
        Database::class
    ];

    /**
     * @return bool
     */
    public function initiateManagers() : bool
    {
        foreach (self::$glob as $global) {
            foreach (self::$class as $classes) {
                $base_name = basename($classes);
                $cl = strtolower(trim($base_name, 'manager'));
                if (strpos($cl, 'manager') === false) {
                    $cl .= 'Manager';
                    //$glob_reflection = new ReflectionClass($global);
                    try {
                        new $global($this);
                        $this->{$cl} = new $classes($this);
                    } catch (\Exception $exception) {
                        $this->getLogger()->error("failed to initiate {$exception->getFile()}: {$exception->getTraceAsString()}");
                        return false;
                    }
                }
            }
        }
        return true;
    }
}