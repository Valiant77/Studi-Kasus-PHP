<?php

namespace App\Services;

use App\Contracts\NotifikasiInterface;

class WhatsappNotifikasi implements NotifikasiInterface
{
    public function kirim($pesan)
    {
        return "Whatsapp terkirim: " . $pesan;
    }
}

?>