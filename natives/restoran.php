<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Manajemen Restoran</title>
        <style>
            body {font-family: Arial; background: #f5f5f5; margin: 0; padding: 20px;}
            h2 {color: #333; margin-top: 0}
            table {width: 100%; border-collapse: collapse; margin: 15px 0}
            table th {background: #d35400; color: white; padding: 10px; text-align: left; border: 1px solid #ddd;}
            table td {padding: 10px; border: 1px solid #ddd;}
            table tbody tr:nth-child(even) {background: #f9f9f9;}
            ul {list-style: none; padding: 0}
            ul li {background: #f0f0f0; padding: 10px; margin: 8px 0; border-left: 4px solid #d35400;}
            .container {max-width: 900px; margin: 0 auto; background: white; padding: 20px; border: 1px solid #ddd;}
            .header { background: #d35400; color: white; padding: 20px; margin: -20px -20px 20px -20px; text-align: center;}
            .header h1 {margin: 0;}
            .section {margin: 20px 0; border-bottom: 1px solid #ddd; padding-bottom: 20px;}
            .harga-mahal {background: #ffb6c6; padding: 5px;}
            .harga-murah {background: #90ee90; padding: 5px;}
            .pesanan {background: #f9f9f9; padding: 15px; margin: 15px 0; border-left: 4px solid #d35400;}
            .sukses {color: green; padding: 8px;}
            .gagal {color: red; padding: 8px}
            .struk {background: #222; color: #fff; padding: 15px; font-family: monospace; font-size: 12px; max-height: 350px; overflow-y: auto;}
            .footer {text-align: center; color: #666; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header"><h1>SISTEM MANAJEMEN RESTORAN</h1><p>Restaurant Management - SMK</p></div>
            <?php
                //Menu stuff
                interface MenuInterface {
                    public function getInfo();
                    public function cekKetersediaan();
                }
                abstract class Menu implements MenuInterface {
                    private $id, $nama, $harga, $kategori, $stok;
                    public function __construct($id, $nama, $harga, $kategori, $stok) {
                        $this->id = $id; $this->nama = $nama; $this->harga = $harga;
                        $this->kategori = $kategori;$this->stok = $stok;
                    }

                    public function getId() {return $this->id;}
                    public function getNama() {return $this->nama;}
                    public function getHarga() {return $this->harga;}
                    public function getKategori() {return $this->kategori;}
                    public function getStok() {return $this->stok;}
                    abstract public function getDeskripsi();
                    public function cekKetersediaan() {return $this->stok > 0 ? true : false;}
                    public function kurangiStok($jumlah) {$this->stok -= $jumlah; if ($this->stok < 0) $this->stok = 0;}
                    public function __toString() {return "{$this->nama} - Rp" . number_format($this->harga);}
                }
                //My children...
                class Makanan extends Menu {
                    private $bahan;
                    public function __construct($id, $nama, $harga, $kategori, $stok, $bahan) {
                        parent::__construct($id, $nama, $harga, $kategori, $stok);
                        $this->bahan = $bahan;
                    }
                    public function getBahan() {return $this->bahan;}
                    public function getDeskripsi() {return "Makanan: <b>{$this->getNama()}</b> ({$this->getKategori()})";}
                    public function getInfo() {return $this->__toString() . " - Bahan: {$this->bahan}";}
                }
                class Minuman extends Menu {
                    private $ukuran;
                    public function __construct($id, $nama, $harga, $kategori, $stok, $ukuran) {
                        parent::__construct($id, $nama, $harga, $kategori, $stok);
                        $this->ukuran = $ukuran;
                    }
                    public function getUkuran() {return $this->ukuran;}
                    public function getDeskripsi() {return "Minuman: <b>{$this->getNama()}</b> ({$this->getUkuran()})";}
                    public function getInfo() {return $this->__toString() . " - Ukuran: {$this->ukuran}";}
                }
                class Dessert extends Menu { //6. Buat class baru: Dessert
                    private $kalori;
                    public function __construct($id, $nama, $harga, $kategori, $stok, $kalori) {
                        parent::__construct($id, $nama, $harga, $kategori, $stok);
                        $this->kalori = $kalori;
                    }
                    public function getUkuran() {return $this->ukuran;}
                    public function getDeskripsi() {return "Dessert: <b>{$this->getNama()}</b> ({$this->getKategori()})";}
                    public function getInfo() {return $this->__toString() . " - Harga: {$this->harga}" . " - Kalori: {$this->ukuran}";}
                }
                //something something
                trait AuditLog {
                    private $logAktivitas = [];
                    public function tambahLog($aktivitas) {$this->logAktivitas[] = "[" . date('Y-m-d H:i:s') . "] " . $aktivitas;}
                    public function getLogs() {return $this->logAktivitas;}
                }

                //ristorante
                class Restoran {
                    use AuditLog;
                    private $nama, $daftarMenu = [], $pesanan = [], $diskon;
                    public function __construct($nama) {
                        $this->nama = $nama;
                        $this->tambahLog("Restoran '{$nama}' dibuka");
                    }
                    public function getNama() {return $this->nama;}
                    public function tambahMenu(Menu $menu) {
                        $this->daftarMenu[$menu->getId()] = $menu;
                        $this->tambahLog("Menu '{$menu->getNama()}' ditambahkan");
                    }
                    public function cariMenu($id) {return isset($this->daftarMenu[$id]) ? $this->daftarMenu[$id] : null;}
                    public function getFilterByKategori($kategori) { //8. Membuat method baru
                        //slight note: I feel like this can streamlined to just using one function, no? All I add is an argument and conditional
                        $hasItem = false;
                        $html = "<div><h2>Daftar Menu</h2><table><thead><tr><th>ID</th><th>Nama</th><th>Harga</th><th>Kategori</th><th>Stok</th></tr></thead><tbody>";
                        foreach ($this->daftarMenu as $m) {
                            if ($m->getKategori() === ucfirst($kategori)) { //edge case: in case cashier too lazy to capitalize
                                $hasItem = true;
                                $harga = $m->getHarga();
                                $status = $harga > 50000 ? "<span class='harga-mahal'>Rp" . number_format($harga) . "</span>" : "<span class='harga-murah'>Rp" . number_format($harga) . "</span>";
                                $html .= "<tr><td>{$m->getId()}</td><td>{$m->getNama()}</td><td>{$status}</td><td>{$m->getKategori()}</td><td>{$m->getStok()}</td></tr>";
                            }
                        }
                        if (!$hasItem) $html .= "<tr><td colspan='5'>Tidak ada menu di '{$kategori}'</td></tr>"; //edge case: invalid category
                        return $html . "</tbody></table></div>";
                    }
                    public function getTabelMenu() {
                        $html = "<div><h2>Daftar Menu</h2><table><thead><tr><th>ID</th><th>Nama</th><th>Harga</th><th>Kategori</th><th>Stok</th></tr></thead><tbody>";
                        foreach ($this->daftarMenu as $m) {
                            $harga = $m->getHarga();
                            $status = $harga > 50000 ? "<span class='harga-mahal'>Rp" . number_format($harga) . "</span>" : "<span class='harga-murah'>Rp" . number_format($harga) . "</span>";
                            $html .= "<tr><td>{$m->getId()}</td><td>{$m->getNama()}</td><td>{$status}</td><td>{$m->getKategori()}</td><td>{$m->getStok()}</td></tr>";
                        }
                        return $html . "</tbody></table></div>";
                    }
                    public function getDeskripsi() {
                        $html = "<div class='section'><h2>Deskripsi Menu</h2><ul>";
                        foreach ($this->daftarMenu as $m) $html .= "<li>" . $m->getDeskripsi() . "</li>";
                        return $html . "</ul></div>";
                    }
                    public function pesanMenu($id, $jumlah) {
                        $menu = $this->cariMenu($id);
                        if ($menu && $menu->cekKetersediaan() && $menu->getStok() >= $jumlah) {
                            $menu->kurangiStok($jumlah);
                            $this->pesanan[] = array("menu" => $menu, "jumlah" => $jumlah, "subtotal" => $menu->getHarga() * $jumlah);
                            $this->tambahLog("Menu '{$menu->getNama()}' dipesan {$jumlah} porsi");
                            return "<p class='sukses'>Menu '{$menu->getNama()}' berhasil dipesan</p>";
                        }
                        return "<p class='gagal'>Menu tidak tersedia atau stok kurang!</p>";
                    }
                    public function setDiskon($persentase) {$this->diskon = $persentase > 50 ? 50 : $persentase;} //9. Sistem diskon
                    public function getDiskon() {return $this->diskon . "%";}
                    public function hitungTotal() {
                        $total = 0;
                        foreach ($this->pesanan as $p) $total += $p["subtotal"];
                        return $total - ($total * ($this->diskon)/100);
                    }
                    public function getStruk() {
                        $html = "<div class='section'><h2>Struk Pesanan</h2><div class='struk'>";
                        $html .= "=== STRUK PESANAN ===" . "<br>";
                        $html .= "Tanggal: " . date('Y-m-d H:i:s') . "<br>";
                        $html .= "---<br>";
                        foreach ($this->pesanan as $p) {
                            $html .= $p["menu"]->getNama() . " x" . $p["jumlah"] . " = Rp" . number_format($p["subtotal"]) . "<br>";
                        }
                        $html .= "---<br>";
                        $html .= "Diskon {$this->getDiskon()}<br>";
                        $html .= "Total: Rp" . number_format($this->hitungTotal()) . "<br>";
                        $html .= "===================================<br>";
                        return $html . "</div></div>";
                    }
                    public function getLog() {
                        $html = "<div class='section'><h2>Log Aktivitas</h2><div class='struk'>";
                        foreach ($this->getLogs() as $log) $html .= htmlspecialchars($log) . "<br>";
                        return $html . "</div></div>";
                    }
                }
                //now call the fags
                $restoran = new Restoran("Restoran Nusantara"); //1. Ubah nama restoran
                $setmenus = [ //changed it to a multidim array for the new solution belllow
                "m1" => new Makanan(1, "Nasi Goreng", 30000, "Makanan", 60, "Beras, Telur, Bawang"), //3. Ubah harga menu makanan dan 5. Ubah stok menu
                "m2" => new Makanan(2, "Mie Goreng", 25000, "Makanan", 55, "Mie, Telur, Saus"),
                "m3" => new Makanan(3, "Ayam Goreng", 40000, "Makanan", 40, "Ayam, Tepung, Minyak"), //sampai sini
                "m4" => new Minuman(4, "Es Teh", 10000, "Minuman", 120, "Besar"), //4. Ubah harga menu minuman dan 5. Ubah stok menu
                "m5" => new Minuman(5, "Jus Buah", 15000, "Minuman", 100, "Besar"),
                "m6" => new Makanan(6, "Soto Ayam", 18000, "Makanan", 35, "Ayam, Kunyit, Bawang"), //2. Tambah menu baru
                "m7" => new Minuman(7, "Kopi", 10000, "Minuman", 90, "Sedang"), //dan ini
                "m8" => new Dessert(8, "Es Krim", 15000, "Dessert", 45, 150)
                ];

                //$restoran->tambahMenu($m1);$restoran->tambahMenu($m2);$restoran->tambahMenu($m3);$restoran->tambahMenu($m4);$restoran->tambahMenu($m5);
                foreach ($setmenus as $sm) { $restoran->tambahMenu($sm); } //this is my less convoluted solution just decomment above and comment this if you hate it

                echo $restoran->setDiskon(10); //9. Sistem diskon
                //echo $restoran->getTabelMenu();
                echo $restoran->getFilterByKategori("makanan");
                echo $restoran->getDeskripsi();
                //7. Ubah simulasi pesanan
                // echo $restoran->pesanMenu(1, 2);
                // echo $restoran->pesanMenu(4, 3);
                // echo $restoran->pesanMenu(3, 1); //BEFORE
                echo $restoran->pesanMenu(2, 3);
                echo $restoran->pesanMenu(5, 2);
                echo $restoran->pesanMenu(1, 2);
                echo $restoran->pesanMenu(4, 5); //AFTER
                echo $restoran->getStruk();
                echo $restoran->getLog();
            ?>
            <div class="footer"><p>Copyright 2026 - Sistem Manajemen Restoran</p></div>
        </div>
    </body>
</html>