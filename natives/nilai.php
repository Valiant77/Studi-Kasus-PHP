<?php

class Siswa {
    private string $nama;
    private string $kelas;
    private int $nis;
    private int $nilai;
    private bool $status;

    public function __construct(string $nama, string $kelas, int $nis) {
        $this->nama = $nama;
        $this->kelas = $kelas;
        $this->nis = $nis;
    }

    #nama nis kelas nilai
    public function cekKelulusan(int $nilai) {
        $status = $nilai >= 75;
        $this->tampilkanData($nilai, $status);
    }

    public function tampilkanData(int $nilai, bool $status) {
        echo "Nama: " . $this->nama . "\n";
        echo "Kelas: " . $this->kelas . "\n";
        echo "NIS: " . $this->nis . "\n";
        echo "Nilai: " . $nilai . "\n";
        echo "Status: " . ($status ? "Lulus" : "Tidak Lulus") . "\n";
        echo "-----------------------------------\n";
    }
}

    $daftarSiswa = [];
    $daftarSiswa[] = new Siswa("Andi", "XII RPL 2", 12400005);
    $daftarSiswa[] = new Siswa("Budi", "XII RPL 2", 12200002);
    $daftarSiswa[] = new Siswa("Cica", "XII RPL 2", 12300008);

    foreach ($daftarSiswa as $ds) {
        $nilaiInput = random_int(70, 100);
        $ds->cekKelulusan($nilaiInput);
    }

?>