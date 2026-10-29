<?php

declare(strict_types=1);

namespace MysticalChest\timer;

class Timer
{
    private int $creation;
    private int $activation;
    private int $removal;

    public function __construct(int $creation = -1, int $activation =-1, int $removal = -1)
    {
        $this->creation = $creation;
        $this->activation = $activation;
        $this->removal = $removal;
    }

    public function getCreation() : int
    {
        return $this->creation;
    }

    public function setCreation(int $creation) : self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getActivation() : int
    {
        return $this->activation;
    }

    public function setActivation(int $activation) : self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getRemoval() : int
    {
        return $this->removal;
    }

    public function setRemoval(int $removal) : self
    {
        $this->removal = $removal;

        return $this;
    }
}
