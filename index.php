<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pembayaran</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-body: #f8fafc;
            --text-dark: #334155;
            --border-color: #e2e8f0;
        }

        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            background-color: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
        }

        .container {
            background: white;
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 420px;
            border: 1px solid var(--border-color);
        }

        h1 { 
            text-align: left; 
            margin-bottom: 1.5rem; 
            font-size: 1.25rem;
            color: #0f172a;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .form-group { margin-bottom: 1.2rem; }

        label { 
            display: block; 
            margin-bottom: 0.5rem; 
            font-size: 0.875rem;
            font-weight: 500; 
        }

        input, select { 
            width: 100%; 
            padding: 0.625rem; 
            box-sizing: border-box; 
            border: 1px solid var(--border-color); 
            border-radius: 6px; 
            font-size: 0.95rem;
            background-color: #ffffff;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        button { 
            width: 100%;
            background-color: var(--primary-color); 
            color: white; 
            border: none; 
            padding: 0.75rem;
            border-radius: 6px;
            cursor: pointer; 
            font-size: 0.95rem; 
            font-weight: 600;
            margin-top: 0.5rem;
        }

        button:hover { background-color: var(--primary-hover); }

        .hasil { 
            margin-top: 1.5rem; 
            padding: 1.25rem; 
            border-radius: 6px; 
            background-color: #f1f5f9; 
            border-left: 4px solid var(--primary-color);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .hasil h3 { margin-top: 0; color: #1e293b; font-size: 1rem; margin-bottom: 0.75rem; }

        .diskon { color: #059669; font-weight: 600; }
        
        .total-row {
            border-top: 1px solid #cbd5e1;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            font-size: 1rem;
            color: #0f172a;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Konfirmasi Pembayaran</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="jumlah">Jumlah Nominal (IDR)</label>
                <input type="number" id="jumlah" name="jumlah" placeholder="0" min="1000" required>
            </div>

            <div class="form-group">
                <label for="metode">Metode Pembayaran</label>
                <select id="metode" name="metode" required onchange="tampilkanDetailMetode()">
                    <option value="">Pilih Metode</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Virtual Account">Virtual Account</option>
                    <option value="QRIS">QRIS</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="COD">COD (Bayar di Tempat)</option>
                </select>
            </div>

            <div class="form-group" id="detailMetode" style="display: none;">
                <label id="labelDetail"></label>
                <input type="text" id="inputDetail" name="detailMetode">
            </div>

            <button type="submit" name="proses">Proses Transaksi</button>
        </form>

        <?php
        require 'pembayaran.php';

        if (isset($_POST['proses'])) {
            $jumlahAwal = $_POST['jumlah'];
            $metodeBayar = $_POST['metode'];
            $detailMetode = $_POST['detailMetode'] ?? "-";

            switch ($metodeBayar) {
                case "Transfer Bank": $pembayaran = new TransferBank(); break;
                case "Virtual Account": $pembayaran = new VirtualAccount(); break;
                case "QRIS": $pembayaran = new QRIS(); break;
                case "E-Wallet": $pembayaran = new EWallet(); break;
                case "COD": $pembayaran = new COD(); break;
                default: exit;
            }

            $pembayaran->setJumlah($jumlahAwal);
            $jumlahAkhir = $pembayaran->hitungTotal();

            echo "<div class='hasil'>";
            echo "<h3>Detail Transaksi</h3>";
            echo "<strong>Metode:</strong> $metodeBayar ($detailMetode)<br>";
            echo "<strong>Subtotal:</strong> Rp " . number_format($jumlahAwal, 0, ',', '.') . "<br>";
            
            if ($pembayaran->getDiskon() > 0) {
                echo "<span class='diskon'>Diskon (" . $pembayaran->getDiskon() . "%): -Rp " . number_format($pembayaran->hitungDiskon(), 0, ',', '.') . "</span><br>";
            }
            
            echo "<div class='total-row'><strong>Total Bayar: Rp " . number_format($jumlahAkhir, 0, ',', '.') . "</strong></div>";
            echo "</div>";
        }
        ?>
    </div>

    <script>
        function tampilkanDetailMetode() {
            const metode = document.getElementById('metode').value;
            const detailDiv = document.getElementById('detailMetode');
            const labelDetail = document.getElementById('labelDetail');
            const inputDetail = document.getElementById('inputDetail');

            if (metode) {
                detailDiv.style.display = 'block';
                const config = {
                    "Transfer Bank": ["Nama Bank pengirim:", "Misal: BCA, Mandiri"],
                    "Virtual Account": ["Nomor Rekening VA:", "Masukkan 10-16 digit nomor"],
                    "QRIS": ["ID Merchant:", "Masukkan ID QRIS"],
                    "E-Wallet": ["Provider E-Wallet:", "Misal: OVO, Dana, ShopeePay"],
                    "COD": ["Alamat Lengkap:", "Nama jalan, nomor rumah, kota"]
                };
                labelDetail.textContent = config[metode][0];
                inputDetail.placeholder = config[metode][1];
            } else {
                detailDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>