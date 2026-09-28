<?php

namespace App\Services;

use App\Contracts\PembayaranInterface;

class EWalletPembayaran implements PembayaranInterface
{
    public function bayar($jumlah)
    {
        return "Transfer ke E-wallet terkirim: " . $jumlah;
    }
}

?>