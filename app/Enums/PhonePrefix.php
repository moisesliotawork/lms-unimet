<?php

namespace App\Enums;

enum PhonePrefix: string
{
    case _0412 = '0412';
    case _0414 = '0414';
    case _0424 = '0424';
    case _0416 = '0416';
    case _0426 = '0426';

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->value])
            ->toArray();
    }
}
