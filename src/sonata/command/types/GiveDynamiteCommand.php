<?php

namespace sonata\command\types;


use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use sonata\command\Command;
use sonata\item\unique\Dynamite;
use sonata\translation\Translation;

class GiveDynamiteCommand extends Command
{
    public function __construct()
    {
        parent::__construct("givedynamite", "Give Dynamite to a Player/Everyone", Translation::EC_RED."/givedynamite <player> <id> <count>", []);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
       if ($sender instanceof Player) {
           if (!$sender->isOp()) {
               $sender->sendMessage(Translation::getMessage("noPerm"));
               return;
           }
           if (isset($args[0])) {
               $player = Server::getInstance()->getPlayer($args[0]);
               if ($player === null) {
                   $sender->sendMessage(Translation::getMessage("nullPlayer"));
                   return;
               }
               if (!isset($args[1]) || !isset($args[2])) {
                   $sender->sendMessage($this->getUsage());
                   return;
               }
               if (is_int($args[1]) || is_int($args[2])) {
                   $item = new Dynamite($args[1]);
                   $item->setCount($args[2]);

                   $custom = $item->getCustomName() == "" ?  $item->getVanillaName() : $item->getCustomName();

                   $player->getInventory()->addItem($item);
                   if ($player !== $sender) {
                       $player->sendMessage(Translation::getMessage("itemGiven",[
                           "item" => $custom,
                           "count" => $item->getCount()
                       ]));

                       $sender->sendMessage(Translation::getMessage("itemGive"),[
                           "player" => $player->getName(),
                           "item" => $custom,
                           "count" => $item->getCount()
                       ]);
                   }
                   $player->sendMessage(Translation::getMessage("itemGive",[
                       "player"  => "Your self",
                       "item" => $custom,
                       "count" => $item->getCount()
                   ]));
               }
               $player->sendMessage(Translation::getMessage("invalidInt"));
               return;
           }
           $sender->sendMessage($this->getUsage());

       }
       return;
    }
}