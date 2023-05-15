<?php

namespace App\Enums;

enum LevelOfEducation: int
{
    case child = 1;
    case fundamental = 2;
    case middle = 3;
    case technical = 4;
    case higher = 5;

    public function description(): string
    {
        return match($this) {
            static::child => 'Infantil',
            static::fundamental => 'Fundamental',
            static::middle => 'Médio',
            static::technical => 'Técnico',
            static::higher => 'Superior'
        };
    }

    public static function toArray(): array
    {
        foreach(static::cases() as $case)
            $ar[$case->value] = $case->description();

        return $ar;
    }
}
