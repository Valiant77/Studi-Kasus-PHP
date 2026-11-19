<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestoController extends Controller
{
    public function index()
    {
        $menu = [
            ["id" => 1, "nama" => "Nasi Goreng Gila Banget", "harga" => "Rp10.000", "tersedia" => true],
            ["id" => 2, "nama" => "Mie Ayam Sebelum Mati", "harga" => "Rp8.000", "tersedia" => true],
            ["id" => 3, "nama" => "Es Teh Asli Auditore", "harga" => "Rp3.000", "tersedia" => false],
            ["id" => 4, "nama" => "Bakso Setan", "harga" => "Rp12.000", "tersedia" => true],
        ];
        return view("produk.resto", compact('menu'));
    }
    public function change($id, $av)
    {
        $menu[$id]["tersedia"] = $av ? false : true;
    }
}
