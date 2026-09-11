<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProdukService;

class ProdukController extends Controller
{
    private ProdukService $produkService;

    public function __construct(ProdukService $produkService)
    {
        $this->produkService = $produkService;
    }

    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $tersedia = $request->query('tersedia');
        $hargacon = $request->query('harga_con');

        if ($kategori) {
            $produk = $this->produkService->getByKategori($kategori);
        } elseif ($tersedia) {
            $produk = $this->produkService->getTersedia();
        } elseif ($hargacon) {
            $produk = $this->produkService->getDiAtasHarga((int) $hargaMin);
        } else {
            $produk = $this->produkService->getAllProduk();
        }

        $jumlah = $this->produkService->getJumlahProduk();
        $terbanyak = $this->produkService->getStokTerbanyak();

        return view('produk.index', compact('produk', 'jumlah', 'terbanyak'));
    }
    
}
