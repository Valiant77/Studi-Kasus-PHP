<?php

class Buku {
    private string $kode;
    private string $judul;
    private string $penulis;
    private int $tahunTerbit;
    private bool $dipinjam = false;

    public function __construct(string $kode, string $judul, string $penulis, int $tahunTerbit) {
        $this->kode = $kode;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahunTerbit = $tahunTerbit;
    }

    public function pinjam(): string
    {
        if ($this->dipinjam) {
            return "Buku sedang dipinjam";
        }
        $this->dipinjam = true;
        return "Buku berhasil dipinjam";
    }
    public function kembalikan(): string
    {
        if (!$this->dipinjam) {
            return "Buku tidak sedang dipinjam";
        }
        $this->dipinjam = false;
        return "Buku berhasil dikembalikan, terima kasih!";
    }
    public function getStatus()
    {
        return ($this->dipinjam ? "Dipinjam" : "Tersedia");
    }
    public function getData(): array {
        $kode = $this->kode;
        $judul = $this->judul;
        $penulis = $this->penulis;
        $tahunTerbit = $this->tahunTerbit;
        $status = $this->getStatus();

        return compact('kode', 'judul', 'penulis', 'tahunTerbit', 'status');
    }
}

$daftarBuku = [];
$daftarBuku[] = new Buku("B001", "Dasar Dasar C++", "Siapa ya?", 2005);
$daftarBuku[] = new Buku("B002", "Ingin Menjadi Pengoding Handal Namun Enggan Mengoding", "Fesnuk Steinstein", 1980);
$daftarBuku[] = new Buku("B003", "Kumpulan Cerpen Ngawi #67", "Fuadi Rusdi", 2009);

while (true) {
    echo "\n=== Sistem CLI Perpustakaan ===\n";
    foreach ($daftarBuku as $i => $buku) {
        $data = $buku->getData();
        echo "[$i] {$data['judul']} - {$data['status']}\n";
    }

    echo "\n1. Pinjam buku\n2. Kembalikan buku\n3. Lihat detail buku\n4. Keluar\n";
    echo "Pilih: ";
    $pilihan = trim(fgets(STDIN));

    if ($pilihan == "4") {
        break;
    }

    if (in_array($pilihan, ["1", "2", "3"])) {
        echo "Pilih nomor buku (0-" . (count($daftarBuku) - 1) . "): ";
        $index = trim(fgets(STDIN));

        if (!isset($daftarBuku[$index])) {
            echo "Nomor buku tidak valid.\n";
            continue;
        }

        $buku = $daftarBuku[$index];

        if ($pilihan == "1") {
            echo $buku->pinjam() . "\n";
        } elseif ($pilihan == "2") {
            echo $buku->kembalikan() . "\n";
        } elseif ($pilihan == "3") {
            $data = $buku->getData();
            foreach ($data as $key => $value) {
                echo "$key: $value\n";
            }
        }
    } else {
        echo "Pilihan tidak dikenal.\n";
    }
}
echo "Program selesai.\n";