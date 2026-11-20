<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestoController extends Controller
{
    public function getMenu(): array
    {
        return session('menu', [
            ["id" => 1, "nama" => "Nasi Goreng Gila NPD BPD DID ADHD PTSD OCD RSJ", "harga" => 10000, "tersedia" => true],
            ["id" => 2, "nama" => "Mie Ayam Sebelum Mati", "harga" => 8000, "tersedia" => true],
            ["id" => 3, "nama" => "Es Teh Asli Ngawi Selatan", "harga" => 3000, "tersedia" => false],
            ["id" => 4, "nama" => "Bakso Setan ULTRAKILL Tingkat Treachery", "harga" => 12000, "tersedia" => true],
        ]);
    }
    public function index()
    {
        return view('produk.resto', ['menu' => $this->getMenu()]);
    }
    public function change(Request $request, $id)
    {
        $request->validate(['tersedia' => 'required|in:0,1']);
        $menu = $this->getMenu();
        foreach ($menu as &$m) {
            if ($m['id'] == $id) {
                $m['tersedia'] = $request->boolean('tersedia');
                break;
            }
        }
        unset($m);
        session(['menu' => $menu]);
        return redirect()->route('resto');
    }
}
