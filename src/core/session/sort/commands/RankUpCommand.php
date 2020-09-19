<?php

declare(strict_types=1);

namespace core\session\sort\commands;

use core\commands\Command;
use core\session\sort\PlayerSession;
use core\translation\Translation AS T;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class RankUpCommand extends Command
{
    public function __construct()
    {
        parent::__construct("rankup", "Rank up to your destination", T::RED,['ru']);
    }

    function execute(CommandSender $sender, string $commandLabel, array $param): void
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage($this->get("noPermission"));
            return;
        }

        $player_session = $this->session()->get($sender);
        $money = $player_session->getMoney();
        $remaining = $player_session->getCurrentRemaining();
        $needed = $player_session->getCurrentNeeded();

        if ($player_session->getMine() === 27) {
            // prestie
        }
        if ($money <= $needed) {
            $player_session->setMine(1);
            $player_session->update();
        } else {
            $sender->sendMessage();
        }

        if (!empty($param[1])) {
            switch ($param[1]) :
                case "max":
                case "m":
                    {
                        $a = new class($player_session) extends AsyncTask {

                            private $session;

                            public function __construct(PlayerSession $session)
                            {
                                $this->session = $session;
                            }

                            public function onRun()
                            {
                                $session = $this->session;
                                if ($session->getMoney() === $session->getPrice($session->getMine())) {

                                }
                            }
                        };
                        $this->instance()->getServer()->getAsyncPool()->submitTask($a);

                    }
                    break;
            endswitch;
            $sender->sendMessage(self::getUsage());
        }
    }
}

