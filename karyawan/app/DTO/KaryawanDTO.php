<?php

namespace App\DTO;

abstract class KaryawanDTO {
    public function __construct(protected readonly string $nama, protected readonly string $nip, protected readonly string $departemen, protected readonly string $email) {}

    public function getNama(): string { return $this->nama; }
    public function getNip(): string { return $this->nip; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getEmail(): string { return $this->email; }

    abstract public function getStatus(): string;
    abstract public function hitungGaji(): float;

    public function getGajiFormatted(): string {
        return 'Rp ' . number_format($this->hitungGaji(), 0, ',', '.');
    }
}

class KaryawanTetapDTO extends KaryawanDTO {
    public function __construct(string $nama, string $nip, string $departemen, string $email, private float $gajiPokok, private float $tunjangan, private string $golongan) {
        parent::__construct($nama, $nip, $departemen, $email);
    }

    public function getStatus(): string { return 'Tetap'; }
    public function getGolongan(): string { return $this->golongan; }

    public function hitungGaji(): float {
        return $this->gajiPokok + $this->tunjangan;
    }
}
class KaryawanKontrakDTO extends KaryawanDTO {
    public function __construct(string $nama, string $nip, string $departemen, string $email, private float $gajiPerBulan, private string $masaKontrak) {
        parent::__construct($nama, $nip, $departemen, $email);
    }

    public function getStatus(): string { return 'Kontrak'; }
    public function getMasaKontrak(): string { return $this->masaKontrak; }

    public function hitungGaji(): float {
        return $this->gajiPerBulan;
    }
}

class KaryawanMagangDTO extends KaryawanDTO {
    public function __construct(string $nama, string $nip, string $departemen, string $email, private float $uangSaku, private int $durasiMinggu) {
        parent::__construct($nama, $nip, $departemen, $email);
    }

    public function getStatus(): string { return 'Magang'; }

    public function hitungGaji(): float {
        return $this->uangSaku;
    }
}