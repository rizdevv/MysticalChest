<?php

declare(strict_types=1);

namespace MysticalChest\inventory;

use muqsit\invmenu\InvMenu;
use MysticalChest\MysticalChest;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\type\InvMenuTypeIds;
use MysticalChest\rarity\RarityManager;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;

class MysticalChestInventory extends InvMenu
{
    public function __construct(MysticalChest $mysticalChest)
    {
        parent::__construct(InvMenuHandler::getTypeRegistry()->get(InvMenuTypeIds::TYPE_DOUBLE_CHEST));

        $rarity = $mysticalChest->getRarity();
        $inventory = $this->getInventory();
        $color = RarityManager::getColorByRarity($rarity);
        $contents = RarityManager::getContentsByRarity($rarity, $inventory->getSize());

        $this->setName($color . "Mystical Chest");
        $this->getInventory()->setContents($contents);
        $this->setListener(
            function (InvMenuTransaction $transaction) use ($inventory) : InvMenuTransactionResult
            {
                $action = $transaction->getAction();

                if (!$action->getTargetItem()->isNull())
                {
                    return $transaction->discard();
                }

                return $transaction->continue();
            }
        );
    }
}
