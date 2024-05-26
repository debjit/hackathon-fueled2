<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserType: int implements HasLabel
{
    case Guest = 0;
    case Vendor = 1;

    public function getLabel(): ?string
    {
        return $this->name;

        return match ($this) {
            self::Guest => 'Guest',
            self::Vendor => 'Vendor'
        };
    }
}
