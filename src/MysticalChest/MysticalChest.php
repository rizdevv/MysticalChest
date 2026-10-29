<?php

declare(strict_types=1);

namespace MysticalChest;

use pocketmine\world\World;
use MysticalChest\rarity\RarityIds;
use muqsit\invmenu\InvMenu;
use pocketmine\Server;
use MysticalChest\inventory\MysticalChestInventory;
use pocketmine\world\Position;
use pocketmine\world\format\Chunk;
use pocketmine\block\VanillaBlocks;
use MysticalChestManager;
use RuntimeException;

class MysticalChest
{
    private int $x;
    private int $y;
    private int $z;
    private World $world;
    private string $status;
    private RarityIds $rarity;

    private InvMenu $invMenu;
    private TextParticle $textParticle;

    public function __construct(?int $x = null, ?int $y = null, ?int $z = null, ?World $world = null, ?string $status = null, ?RarityIds $rarity = null)
    {
        $this->x = $x ?? mt_rand(-5000, 5000);
        $this->y = $y ?? -1;
        $this->z = $z ?? mt_rand(-5000, 5000);
        $this->world = $world ?? Server::getInstance()->getWorldManager()->getDefaultWorld();
        $this->status = $status ?? StatusTypeIds::UNACTIVATED;

        $chance = mt_rand(1, 100);

        $this->rarity = $rarity ?? match (true)
        {
            $chance <= 5 => RarityIds::ELITE,
            $chance <= 15 => RarityIds::RICH,
            $chance <= 30 => RarityIds::SOLID,
            default => RarityIds::COMMON
        };
        $this->invMenu = new MysticalChestInventory($this);
        $this->textParticle = new TextParticle($this, $this->getPosition());
    }

    public function getX() : int
    {
        return $this->x;
    }

    public function setX(int $x) : self
    {
        $this->x = $x;

        return $this;
    }

    public function getY() : int
    {
        return $this->y;
    }

    public function setY(int $y) : self
    {
        $this->y = $y;

        return $this;
    }

    public function getZ() : int
    {
        return $this->z;
    }

    public function setZ(int $z) : self
    {
        $this->z = $z;

        return $this;
    }

    public function getWorld() : World
    {
        return $this->world;
    }

    public function setWorld(World $world) : self
    {
        $this->world = $world;

        return $this;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function setStatus(string $status) : self
    {
        $this->status = $status;

        return $this;
    }

    public function getRarity() : RarityIds
    {
        return $this->rarity;
    }

    public function setRarity(RarityIds $rarity) : self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getInvMenu() : InvMenu
    {
        return $this->invMenu;
    }

    public function setInvMenu(InvMenu $invMenu) : self
    {
        $this->invMenu = $invMenu;

        return $this;
    }

    public function getTextParticle() : TextParticle
    {
        return $this->textParticle;
    }

    public function setTextParticle(TextParticle $textParticle) : self
    {
        $this->textParticle = $textParticle;

        return $this;
    }

    public function getPosition() : Position
    {
        return new Position($this->getX(), $this->getY(), $this->getZ(), $this->getWorld());
    }

    public function setPosition(Position $position) : self
    {
        $this->setX($position->getFloorX());
        $this->setY($position->getFloorY());
        $this->setZ($position->getFloorZ());
        $this->setWorld($position->getWorld());

        return $this;
    }

    public function create() : self
    {
        $world = $this->getWorld();
        $x = $this->getX();
        $chunkSize = Chunk::COORD_BIT_SIZE;
        $z = $this->getZ();

        $world->orderChunkPopulation($x >> $chunkSize, $z >> $chunkSize, null)->onCompletion(
            function () use ($world, $x, $z) : void
            {
                $highestBlock = $world->getHighestBlockAt($x, $z);

                if ($highestBlock)
                {
                    $y = $highestBlock + 1;

                    $this->setY($y);
                    $world->setBlockAt($x, $y, $z, VanillaBlocks::ENDER_CHEST());
                    $this->setInvMenu(new MysticalChestInventory($this));
                    $this->getTextParticle()->add(0);
                    MysticalChestManager::setMysticalChest($this);
                    Server::getInstance()->broadcastMessage("$x $y $z");

                    return;
                }

                throw new RuntimeException("Highest block not found");
            },
            fn () => null
        );

        return $this;
    }

    public function remove() : self
    {
        $mysticalChest = MysticalChestManager::getMysticalChest();
        $world = $this->getWorld();
        $x = $this->getX();
        $chunkSize = Chunk::COORD_BIT_SIZE;
        $z = $this->getZ();
        $chunkX = $x >> $chunkSize;
        $chunkZ = $z >> $chunkSize;
        $y = $this->getY();

        if ($mysticalChest)
        {
            $invMenu = $mysticalChest->getInvMenu();
            $viewers = $invMenu->getInventory()->getViewers();

            foreach ($viewers as $viewer)
            {
                $invMenu->onClose($viewer);
            }
        }

        if (!$world->isChunkLoaded($chunkX, $chunkZ))
        {
            $world->loadChunk($chunkX, $chunkZ);
        }

        $world->setBlockAt($x, $y, $z, VanillaBlocks::AIR());
        $this->getTextParticle()->remove();
        MysticalChestManager::setMysticalChest(null);

        return $this;
    }
}
