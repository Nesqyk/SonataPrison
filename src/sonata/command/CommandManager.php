<?php

declare(strict_types=1);

namespace sonata\command;

use pocketmine\command\utils\CommandException;
use pocketmine\Server;
use sonata\command\types\GiveDynamiteCommand;
use sonata\Sonata;

class CommandManager
{
    public function __construct(Sonata $sonata)
    {
        $this->init();
    }

    public function init() {
        $this->register(new GiveDynamiteCommand());
    }

    /**
     * @param Command $cmd
     */
    public function register(Command $cmd) {
        $map = Server::getInstance()->getCommandMap();
        if ($cmd->isRegistered()) {
            throw new CommandException("$cmd is already registered!");
        }
        $map->register($cmd->getName(),$cmd);
    }

    /**
     * @param string $command
     */
    public function unregister(string $command) {
        $map = Server::getInstance()->getCommandMap();
        $commando = $map->getCommand($command);
        if ($commando !== null) {
            $map->unregister($commando);
        }
    }
}