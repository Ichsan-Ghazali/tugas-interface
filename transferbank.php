<?php
class TransferBank {
    // Deklarasi properti dengan akses modifier yang jelas
    private $jumlah;

    // Fungsi untuk mengatur nilai jumlah
    public function setJumlah($nilai) {
        // Validasi agar nilai tidak negatif
        if ($nilai >= 0) {
            $this->jumlah = $nilai;
        } else {
            $this->jumlah = 0;
        }
    }

    // Fungsi untuk mengambil nilai jumlah
    public function getJumlah() {
        return $this->jumlah;
    }
}
?>