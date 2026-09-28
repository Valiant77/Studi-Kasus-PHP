<?php

namespace App\Services;

use App\Contracts\NotifikasiInterface;

class EmailNotifikasi implements NotifikasiInterface
{
    public function kirim($pesan)
    {
        return "Email terkirim: " . $pesan;
    }
}

?>