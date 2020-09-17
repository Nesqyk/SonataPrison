<?php

declare(strict_types=1);

namespace core\traits;

use core\provider\ProviderManager;

trait ClassManager
{
    private static $MANAGERS = [
      ProviderManager::class
    ];

    public function initiateManager() : bool
    {
        foreach (self::$MANAGERS as $class_name) {
            $base_name = basename($class_name);
            if (!ctype_lower($base_name)) {
                $base_name = strtolower(trim($base_name, "anager"));
                if (strpos($base_name,"Manager") === false) {
                    $base_name = trim($base_name,"m")."Manager";
                    try {
                        $this->setPropertyValue($base_name, new $class_name($this));
                    } catch (\Exception $exception) {
                        $this->getLogger()->warning("failed to initiate {$exception->getFile()}  : {$exception->getMessage()}");
                        return false;
                    }
                }
            }
        }
        return true;
    }


}