<?php
require_once 'Pembayaran.php';
require_once 'Cetak.php';

#Penggunaan Class Virtual Account
class VirtualAccount extends Pembayaran implements Cetak {

    public function prosesPembayaran() {
        if ($this->validasi()) {
            return "Pembayaran Virtual Account sebesar Rp {$this->jumlah} telah diterima";
        }
        return "Jumlah tidak valid";
    }

    public function cetakStruk() {
        return "Struk Virtual Account: Rp {$this->jumlah} (Lunas)";
    }
}
?>