<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferPembayaran;
use App\Services\EWalletPembayaran;
use App\Services\CashPembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $jumlah = "Rp" . (random_int(1, 20)) * 1000;

        $pembayaran = [
            new TransferPembayaran(),
            new EWalletPembayaran(),
            new CashPembayaran()
        ];

        $hasil = [];

        foreach ($pembayaran as $p) {
            $hasil[] = $p->bayar($jumlah);
        }

        return view('pembayaran', ['hasil' => $hasil]);
    }
}
