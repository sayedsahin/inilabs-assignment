<?php

namespace App;

enum TaskStatus: int
{
    case INCOMPLETE = 0;
    case COMPLETE   = 1;
    case CANCELED   = 2;

    public function label(): string
    {
        return match ($this) {
            self::INCOMPLETE => 'Incomplete',
            self::COMPLETE   => 'Complete',
            self::CANCELED   => 'Canceled',
        };
    }
}
