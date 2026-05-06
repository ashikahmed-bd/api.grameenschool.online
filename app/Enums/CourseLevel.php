<?php

namespace App\Enums;

enum CourseLevel: string
{
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';
    case ALL = 'all';

    public static function getValues(): array
    {
        return array_map(fn ($level) => $level->value, self::cases());
    }

    public static function getArray(): array
    {
        return array_map(fn ($level) => [
            'id' => $level->value,
            'name' => ucfirst($level->value),
        ], self::cases());
    }
}
