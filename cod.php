<?php
require_once 'Pembayaran.php';
require_once 'Cetak.php';

// Class COD
class COD extends Pembayaran implements Cetak {
    public function prosesPembayaran() {
        if ($this->validasi()) {
            $total = $this->hitungTotal();
            return "Pembayaran COD - Jumlah Awal: Rp {$this->jumlah}, Diskon 10%, Pajak 11%, Total Bayar: Rp {$total} berhasil";
        }
        return "Jumlah tidak valid";
    }

    public function cetakStruk() {
        $total = $this->hitungTotal();
        return "Struk COD:<br>Jumlah Awal: Rp {$this->jumlah}<br>Diskon (10%): Rp " . ($this->jumlah * $this->diskon / 100) . "<br>Pajak (11% dari setelah diskon): Rp " . (($this->jumlah - ($this->jumlah * $this->diskon / 100)) * $this->pajak / 100) . "<br>Total Bayar: Rp {$total}";
    }
}
?>