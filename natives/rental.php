<?php

class Kendaraan {
    protected string $kode;
    protected string $merek;
    protected int $tarifPerHari;
    protected bool $status = false; //kalo true dipinjam, false tersedia

    public function __construct(string $kode, string $merek, int $tarifPerHari) {
        $this->kode = $kode;
        $this->merek = $merek;
        $this->tarifPerHari = $tarifPerHari;
    }
    
    public function sewa() {
        if ($this->status) {
            return "Tidak bisa dipinjam, karena sedang dipinjam";
        }
        $this->status = true;
        return "Berhasil dipinjam";
    }
    public function kembalikan() {
        if (!$this->status) {
            return "Tidak bisa dikembalikan, karena belum dipinjam";
        }
        $this->status = false;
        return "Berhasil dikembalikan";
    }
    public function hitungBiaya(int $lamaSewa) {
        return $this->tarifPerHari * $lamaSewa;
    }
    public function getData(): array {
        $kode = $this->kode;
        $merek = $this->merek;
        $tarifPerHari = $this->tarifPerHari;
        $status = $this->status ? "Dipinjam" : "Tersedia";

        return compact("kode", "merek", "tarifPerHari", "status");
    }

}
class Mobil extends Kendaraan {
    protected int $asuransi;

    public function __construct(string $kode, string $merek, int $tarifPerHari, int $asuransi) {
        parent::__construct($kode, $merek, $tarifPerHari);
        $this->asuransi = $asuransi;
    }
    public function hitungBiaya(int $lamaSewa) {
        return parent::hitungBiaya($lamaSewa) + $this->asuransi;
    }
}
class Motor extends Kendaraan {
    public function __construct(string $kode, string $merek, int $tarifPerHari) {
        parent::__construct($kode, $merek, $tarifPerHari);
    }
}

//program CLI lagi wow
$daftarKendaraan = [];
$daftarKendaraan[] = new Mobil("M001", "Toyota Avanza", 300000, 50000);
$daftarKendaraan[] = new Mobil("M002", "Honda Brio", 250000, 40000);
$daftarKendaraan[] = new Motor("MT001", "Honda Beat", 80000);
$daftarKendaraan[] = new Motor("MT002", "Yamaha NMAX", 100000);
$daftarKendaraan[] = new Motor("MT003", "Honda Vario", 90000);
 
function tampilkanDaftar(array $daftarKendaraan): void {
    foreach ($daftarKendaraan as $i => $kendaraan) {
        $data = $kendaraan->getData();
        $jenis = $kendaraan instanceof Mobil ? "Mobil" : "Motor";
        echo "[$i] {$data['merek']} ($jenis) - Rp{$data['tarifPerHari']}/hari - {$data['status']}\n";
    }
}
 
function cariByIndex(array $daftarKendaraan, string $index): ?Kendaraan {
    if (!isset($daftarKendaraan[$index])) {
        return null;
    }
    return $daftarKendaraan[$index];
}
 
while (true) {
    echo "\n=== Sistem CLI Rental ===\n";
    tampilkanDaftar($daftarKendaraan);
 
    echo "\n1. Sewa kendaraan\n";
    echo "2. Kembalikan kendaraan\n";
    echo "3. Hitung biaya sewa\n";
    echo "4. Keluar\n";
    echo "Pilih: ";
    $pilihan = trim(fgets(STDIN));
 
    if ($pilihan == "4") {
        break;
    }
 
    if (in_array($pilihan, ["1", "2", "3"])) {
        echo "Pilih nomor kendaraan: ";
        $index = trim(fgets(STDIN));
        $kendaraan = cariByIndex($daftarKendaraan, $index);
 
        if ($kendaraan === null) {
            echo "Nomor kendaraan tidak valid.\n";
            continue;
        }
 
        if ($pilihan == "1") {
            echo $kendaraan->sewa() . "\n";
        } elseif ($pilihan == "2") {
            echo $kendaraan->kembalikan() . "\n";
        } elseif ($pilihan == "3") {
            echo "Lama sewa (hari): ";
            $lamaSewa = (int) trim(fgets(STDIN));
            $biaya = $kendaraan->hitungBiaya($lamaSewa);
            echo "Total biaya: Rp" . $biaya . "\n";
        }
    } else {
        echo "Pilihan tidak dikenal.\n";
    }
}
 
echo "Program selesai.\n";


?>