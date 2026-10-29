<?php

declare(strict_types=1);

namespace MysticalChest\scheduler;

use pocketmine\scheduler\Task;
use MysticalChestManager;
use MysticalChest\MysticalChest;
use MysticalChest\StatusTypeIds;

class TaskHandler extends Task
{
    public function onRun() : void
    {
        $timer = MysticalChestManager::getTimer();
        $creationTimer = $timer->getCreation();
        $activationTimer = $timer->getActivation();
        $removalTimer = $timer->getRemoval();
        $mysticalChest = MysticalChestManager::getMysticalChest();

        $mysticalChest?->getTextParticle()->update($activationTimer);

        if ($creationTimer > 0)
        {
            $timer->setCreation(--$creationTimer);

            return;
        }

        if ($activationTimer > 0)
        {
            $timer->setActivation(--$activationTimer);

            return;
        }

        if ($removalTimer > 0)
        {
            $timer->setRemoval(--$removalTimer);

            return;
        }

        if ($creationTimer == 0)
        {
            $timer->setCreation(-1);

            if (!$mysticalChest)
            {
                $mysticalChest = new MysticalChest();

                $mysticalChest->create();
                $timer->setActivation(600);

                return;
            }
        }

        if ($activationTimer == 0)
        {
            $timer->setActivation(-1);
            $mysticalChest?->setStatus(StatusTypeIds::ACTIVATED);
            $timer->setRemoval(600);

            return;
        }

        if ($removalTimer == 0)
        {
            $timer->setRemoval(-1);

            if ($mysticalChest)
            {
                $mysticalChest->remove();
                $timer->setCreation(10_800);
            }
        }
    }
}
