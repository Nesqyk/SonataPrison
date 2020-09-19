<?php

declare(strict_types=1);

namespace core\commands;

use core\session\sort\commands\RankUpCommand;
use core\Sonata;
use pocketmine\command\utils\CommandException;
use pocketmine\Server;

class CommandManager
{
    public function __construct(Sonata $sonata)
    {
        $this->init();
    }

    public function init() {
        $this->register(new RankUpCommand());
    }

    /**
     * @param Command $command
     */
    public function register(Command $command) {
        $map = Server::getInstance()->getCommandMap();
        if ($map->getCommand($command->getName()) !== null) {
            throw new CommandException("command {$command->getName()} is already registered");
        }
        $map->register($command->getName(),$command);
    }

    public function unregister(string $name) {
        $map = Server::getInstance()->getCommandMap();
        if ($map->getCommand($name) === null) {
            throw new CommandException("command $name doesn't exist");
        }
        $map->unregister($map->getCommand($name));
    }
}
