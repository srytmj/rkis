<?php

namespace App\Helpers;

class RupiahHelper
{
    public static function rupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
