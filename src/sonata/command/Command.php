<?php

namespace sonata\command;


use pocketmine\command\CommandSender;
use pocketmine\Player;
use sonata\traits\TickingTrait;
use sonata\translation\Translation;

class Command extends \pocketmine\command\Command
{
    use TickingTrait;

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->time = 4;
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $sender->sendMessage(Translation::getMessage("commandProcess"),[
                "time" => $this->get($sender)
            ]);
        }
    }
}
