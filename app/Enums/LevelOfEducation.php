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

    public static function get(int $value)
    {
        return match($value) {
            static::child->value => 'Infantil',
            static::fundamental->value => 'Fundamental',
            static::middle->value => 'Médio',
            static::technical->value => 'Técnico',
            static::higher->value => 'Superior',
            default => null,
        };
    }

    public static function toArray(): array
    {
        foreach(static::cases() as $case)
            $ar[$case->value] = $case->description();

        return $ar;
    }
}
