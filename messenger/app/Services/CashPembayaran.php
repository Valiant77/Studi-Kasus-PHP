<?php

namespace App\Services;

use App\Contracts\PembayaranInterface;

class CashPembayaran implements PembayaranInterface
{
    public function bayar($jumlah)
    {
        return "Membayar dengan cash sebanyak: " . $jumlah;
    }
}

?>