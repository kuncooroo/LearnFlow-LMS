<?php

namespace App\Enums;

enum RoleName: string
{
    case Administrator = 'administrator';
    case Instructor = 'instructor';
    case Student = 'student';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
