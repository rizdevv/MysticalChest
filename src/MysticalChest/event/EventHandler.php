<?php

declare(strict_types=1);

namespace MysticalChest\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use MysticalChestManager;
use MysticalChest\StatusTypeIds;
use pocketmine\event\block\BlockBreakEvent;

class EventHandler implements Listener
{
    public function PlayerInteractEvent(PlayerInteractEvent $event) : void
    {
        $mysticalChest = MysticalChestManager::getMysticalChest();
        $action = $event->getAction();
        $rightClick = PlayerInteractEvent::RIGHT_CLICK_BLOCK;
        $position = $event->getBlock()->getPosition();

        if ($mysticalChest && $action == $rightClick && $position->equals($mysticalChest->getPosition()))
        {
            $status = $mysticalChest->getStatus();
            $player = $event->getPlayer();

            $event->cancel();

            if ($status == StatusTypeIds::UNACTIVATED)
            {
                $timer = MysticalChestManager::getTimer();
                $activationTimer = 300;

                $mysticalChest->setStatus(StatusTypeIds::ACTIVATING);

                if ($timer && $timer->getActivation() > $activationTimer)
                {
                    MysticalChestManager::getTimer()->setActivation(5);
                }

                return;
            }

            match ($status)
            {
                StatusTypeIds::ACTIVATING => $player->sendTip("§cIn activation"),
                StatusTypeIds::ACTIVATED => $mysticalChest->getInvMenu()->send($player)
            };
        }
    }

    public function BlockBreakEvent(BlockBreakEvent $event) : void
    {
        $mysticalChest = MysticalChestManager::getMysticalChest();
        $position = $event->getBlock()->getPosition();

        if ($mysticalChest && $position->equals($mysticalChest->getPosition()))
        {
            $event->cancel();
        }
    }
}
