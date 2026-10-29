<?php

declare(strict_types=1);

namespace MysticalChest;

use pocketmine\world\Position;
use pocketmine\world\particle\FloatingTextParticle;
use MysticalChest\rarity\RarityManager;

class TextParticle
{
    private MysticalChest $mysticalChest;
    private Position $position;

    private FloatingTextParticle $particle;

    public function __construct(MysticalChest $mysticalChest, Position $position)
    {
        $this->mysticalChest = $mysticalChest;
        $this->position = $position;

        $this->particle = new FloatingTextParticle("");
    }

    public function getMysticalChest() : MysticalChest
    {
        return $this->mysticalChest;
    }

    public function setMysticalChest(MysticalChest $mysticalChest) : self
    {
        $this->mysticalChest = $mysticalChest;

        return $this;
    }

    public function getPosition() : Position
    {
        return $this->position;
    }

    public function setPosition(Position $position) : self
    {
        $this->position = $position;

        return $this;
    }

    public function getParticle() : FloatingTextParticle
    {
        return $this->particle;
    }

    public function setParticle(FloatingTextParticle $particle) : self
    {
        $this->particle = $particle;

        return $this;
    }

    public function getText(int $timer) : string
    {
        $mysticalChest = $this->getMysticalChest();
        $color = RarityManager::getColorByRarity($mysticalChest->getRarity());
        $status = $mysticalChest->getStatus();
        $text = $color . "Mystical Chest\n" . $status;

        match ($status)
        {
            StatusTypeIds::ACTIVATING => $text .= "\nPreopening: " . $color . $timer . " sec.",
            default => null
        };

        return $text;
    }

    public function add(int $timer) : self
    {
        $mysticalChest = $this->getMysticalChest();
        $position = $mysticalChest->getPosition();
        $world = $position->getWorld();
        $position = Position::fromObject($position->add(0.5, 1.5, 0.5), $world);

        $this->setPosition($position);
        $world->addParticle($position, new FloatingTextParticle($this->getText($timer)));
        $mysticalChest->setTextParticle($this);

        return $this;
    }

    public function remove() : self
    {
        $particle = $this->getParticle();
        $position = $this->getPosition();

        $particle->setInvisible();
        $position->getWorld()->addParticle($position, $particle);

        return $this;
    }

    public function update(int $timer) : self
    {
        $particle = $this->getParticle();
        $position = $this->getPosition();

        $particle->setText($this->getText($timer));
        $position->getWorld()->addParticle($position, $particle);
        $this->getMysticalChest()->setTextParticle($this);

        return $this;
    }
}
