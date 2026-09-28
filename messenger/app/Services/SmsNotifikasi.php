<?php

namespace App\Services;

use App\Contracts\NotifikasiInterface;

class SmsNotifikasi implements NotifikasiInterface
{
    public function kirim($pesan)
    {
        return "SMS terkirim: " . $pesan;
    }
}

?>