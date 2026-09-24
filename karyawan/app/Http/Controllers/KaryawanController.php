<?php

namespace App\Http\Controllers;

require_once app_path('DTO/KaryawanDTO.php'); //Ini dibutuhin karena 3 classnya di satu file

use App\DTO\KaryawanTetapDTO;
use App\DTO\KaryawanKontrakDTO;
use App\DTO\KaryawanMagangDTO;

class KaryawanController extends Controller {
    public function index() {
        $karyawan = [
            new KaryawanTetapDTO(
                nama:       'Budi Santoso',
                nip:        'KT-001',
                departemen: 'Teknologi Informasi',
                email:      'budi@perusahaan.id',
                gajiPokok:  5_500_000,
                tunjangan:  1_200_000,
                golongan:   'III-A'
            ),
            new KaryawanTetapDTO(
                nama:       'Sari Dewi Rahayu',
                nip:        'KT-002',
                departemen: 'Keuangan',
                email:      'sari@perusahaan.id',
                gajiPokok:  6_000_000,
                tunjangan:  1_500_000,
                golongan:   'III-B'
            ),
            new KaryawanKontrakDTO(
                nama:         'Ahmad Fauzi',
                nip:          'KK-001',
                departemen:   'Desain Kreatif',
                email:        'ahmad@perusahaan.id',
                gajiPerBulan: 4_500_000,
                masaKontrak:  '12 Bulan'
            ),
            new KaryawanKontrakDTO(
                nama:         'Rina Amalia Putri',
                nip:          'KK-002',
                departemen:   'Marketing',
                email:        'rina@perusahaan.id',
                gajiPerBulan: 4_000_000,
                masaKontrak:  '6 Bulan'
            ),
            new KaryawanMagangDTO(
                nama:         'Deni Pratama',
                nip:          'KM-001',
                departemen:   'Teknologi Informasi',
                email:        'deni@perusahaan.id',
                uangSaku:     1_500_000,
                durasiMinggu: 12
            ),
        ];
        $totalGaji = array_sum(array_map(fn($k) => $k->hitungGaji(), $karyawan));

        $judulHalaman = 'Portal Karyawan — Daftar Karyawan';
        $jumlahTotal = count($karyawan);
        $bulanTahun = now()->translatedFormat('F Y');

        return view('karyawan.index', compact('karyawan', 'totalGaji', 'judulHalaman', 'jumlahTotal', 'bulanTahun'));
    }

    public function show(string $nip) {
        $karyawan = $this->cariKaryawanByNip($nip);

        if (!$karyawan) {
            abort(404, 'Karyawan tidak ditemukan!');
        }

        $judulHalaman = "Detail Karyawan: {$karyawan->getNama()}";

        return view('karyawan.show', compact('karyawan', 'judulHalaman'));
    }

    public function laporanGaji() {
        $karyawan = $this->getDaftarKaryawan();
        $totalGaji = array_sum(array_map(fn($k) => $k->hitungGaji(), $karyawan));
        $periode = now()->translatedFormat('F Y');
        $judulHalaman = 'Laporan Gaji Bulanan';

        return view('karyawan.laporan', compact('karyawan', 'totalGaji', 'periode', 'judulHalaman'));
    }

    private function cariKaryawanByNip(string $nip): ?KaryawanTetapDTO {
    return null;
    }

    private function getDaftarKaryawan(): array {
        return [];
    }
}