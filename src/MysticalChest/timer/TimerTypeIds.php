<?php

declare(strict_types=1);

namespace MysticalChest\timer;

enum TimerTypeIds : int
{
    case CREATION = 0;
    case ACTIVATION = 1;
    case REMOVAL = 2;
}
