<?php

namespace App\Services;

use App\Contracts\PembayaranInterface;

class TransferPembayaran implements PembayaranInterface
{
    public function bayar($jumlah)
    {
        return "Transfer ke bank terkirim: " . $jumlah;
    }
}

?>