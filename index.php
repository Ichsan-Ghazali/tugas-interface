<?php
require_once 'TransferBank.php';
require_once 'Ewallet.php';
require_once 'Qris.php';
require_once 'VirtualAccount.php';

// Inisialisasi Objek dengan nominal masing-masing
$transfer = new TransferBank(100000);
$ewallet  = new Ewallet(500000);
$qris     = new Qris(750000);
// Menggunakan huruf kecil di awal: $virtualAccount
$virtualAccount = new VirtualAccount(250000);

// Menampilkan Output Transfer Bank
echo "<b>Transfer Bank:</b><br>";
echo $transfer->prosesPembayaran();
echo "<br>";
echo $transfer->cetakStruk();
echo "<br><br>";

// Menampilkan Output E-Wallet
echo "<b>E-Wallet:</b><br>";
echo $ewallet->prosesPembayaran();
echo "<br>";
echo $ewallet->cetakStruk();
echo "<br><br>";

// Menampilkan Output QRIS
echo "<b>QRIS:</b><br>";
echo $qris->prosesPembayaran();
echo "<br>";
echo $qris->cetakStruk();
echo "<br><br>";

// Menampilkan Output Virtual Account
// Pastikan memanggil variabel yang SAMA: $virtualAccount (v kecil)
echo "<b>Virtual Account:</b><br>";
echo $virtualAccount->prosesPembayaran();
echo "<br>";
echo $virtualAccount->cetakStruk();
?>
