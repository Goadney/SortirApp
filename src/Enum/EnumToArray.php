<?php

namespace App\Enum;
trait EnumToArray
{

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function actives(): array
    {
        return [EtatEnum::Ouverte, EtatEnum::EnCours, EtatEnum::Cloturee, EtatEnum::Annulee];
    }
}