<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailNotifikasi;
use App\Services\WhatsappNotifikasi;
use App\Services\SmsNotifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $pesan = "Pesanan #001 berhasil diproses!";

        $notifikasi = [
            new EmailNotifikasi(),
            new WhatsappNotifikasi(),
            new SmsNotifikasi()
        ];

        $hasil = [];

        foreach ($notifikasi as $n) {
            $hasil[] = $n->kirim($pesan);
        }

        return view('notifikasi', ['hasil' => $hasil]);
    }
}
