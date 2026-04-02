<?php
// Kelas induk untuk pembayaran
class Pembayaran {
    protected $jumlah;
    protected $diskonPersen = 0;

    public function setJumlah($nilai) {
        $this->jumlah = $nilai >= 0 ? $nilai : 0;
    }

    public function hitungDiskon() {
        return $this->jumlah * ($this->diskonPersen / 100);
    }

    public function hitungTotal() {
        return $this->jumlah - $this->hitungDiskon();
    }

    public function getDiskon() {
        return $this->diskonPersen;
    }
}

// Kelas masing-masing metode dengan diskon berbeda
class TransferBank extends Pembayaran {
    protected $diskonPersen = 2; // Diskon 2%
}

class VirtualAccount extends Pembayaran {
    protected $diskonPersen = 3; // Diskon 3%
}

class QRIS extends Pembayaran {
    protected $diskonPersen = 5; // Diskon 5%
}

class EWallet extends Pembayaran {
    protected $diskonPersen = 4; // Diskon 4%
}

class COD extends Pembayaran {
    protected $diskonPersen = 0; // Tidak ada diskon
}
?>