<?php

declare(strict_types=1);

namespace App\Enums;

enum FixedFeesTypes: int
{
    case Daily = 1;

    case Weekly = 2;

    case Monthly = 3;

    case Yearly = 4;

    public function getName(): string
    {
        return match ($this) {
            self::Daily => 'codzienna',
            self::Weekly => 'cotygodniowa',
            self::Monthly => 'comiesięczna',
            self::Yearly => 'coroczna',
        };
    }
}
