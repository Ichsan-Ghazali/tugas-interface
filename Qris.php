<?php
require_once 'Pembayaran.php';
require_once 'Cetak.php';

#Penggunaan Class QRIS
class Qris extends Pembayaran implements Cetak {

    public function prosesPembayaran() {
        if ($this->validasi()) {
            return "Pembayaran QRIS sebesar Rp {$this->jumlah} sukses diproses";
        }
        return "Jumlah tidak valid";
    }

    public function cetakStruk() {
        return "Struk QRIS: Rp {$this->jumlah} (Transaksi Digital)";
    }
}
?>
