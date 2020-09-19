<?php

declare(strict_types=1);

namespace core\traits;

use core\provider\ProviderManager;
use core\session\SessionManager;
use core\Sonata;

trait SonataInstance{

    /**
     * @return Sonata|null
     */
    public function instance() {
        return Sonata::getInstance();
    }

    /**
     * @return ProviderManager
     */
    public function provider() {
        return $this->instance()->getProviderManager();
    }

    /**
     * @return SessionManager
     */
    public function session() {
        return $this->instance()->getSessionManager();
    }
}
