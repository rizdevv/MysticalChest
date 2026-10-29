<?php

declare(strict_types=1);

use pocketmine\plugin\PluginBase;
use MysticalChest\timer\Timer;
use MysticalChest\MysticalChest;
use muqsit\invmenu\InvMenuHandler;
use MysticalChest\scheduler\TaskHandler;
use MysticalChest\event\EventHandler;

class MysticalChestManager extends PluginBase
{
    private static ?Timer $timer = null;
    private static ?MysticalChest $mysticalChest = null;

    public function onEnable() : void
    {
        if (!InvMenuHandler::isRegistered())
        {
            InvMenuHandler::register($this);
        }

        $timer = new Timer(10_800);

        self::setTimer($timer);
        $this->getScheduler()->scheduleRepeatingTask(new TaskHandler(), 20);
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
    }

    public static function getTimer() : ?Timer
    {
        return self::$timer;
    }

    public static function setTimer(?Timer $timer) : void
    {
        self::$timer = $timer;
    }

    public static function getMysticalChest() : ?MysticalChest
    {
        return self::$mysticalChest;
    }

    public static function setMysticalChest(?MysticalChest $mysticalChest) : void
    {
        self::$mysticalChest = $mysticalChest;
    }
}
