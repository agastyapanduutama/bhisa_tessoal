<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Transaksi - <?= $transaksi->nomor_transaksi ?></title>
    <style>
        @media print {
            @page {
                margin: 0.5cm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .company-info {
            width: 50%;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 13px;
            line-height: 1.4;
        }
        .customer-info {
            width: 40%;
            font-size: 14px;
            line-height: 1.4;
        }
        .customer-name {
            font-size: 16px;
            font-weight: bold;
        }
        .invoice-no {
            font-size: 15px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
        }
        th {
            background-color: #e0e0e0 !important;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .total-row th, .total-row td {
            font-weight: bold;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .signature-box {
            width: 30%;
            text-align: center;
        }
        .signature-title {
            margin-bottom: 60px;
            text-align: left;
        }
        .signature-name {
            font-weight: bold;
            text-align: left;
        }
        .signature-date {
            margin-bottom: 60px;
            text-align: right;
        }
        .signature-name-right {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<!-- <body onload="window.print()"> -->

<div class="container">
    <div class="header">
        <div class="company-info">
            <div class="company-name">PT. Bhinneka Sangkuriang Transport</div>
            <div class="company-address">
                Jl. Gedebage Selatan No.121A,<br>
                Cisaranten Kidul, Kec. Gedebage,<br>
                Kota Bandung, Jawa Barat 40552
            </div>
        </div>
        <div class="customer-info">
            <div>Kepada Yth :</div>
            <div class="customer-name"><?= htmlspecialchars($transaksi->nama_customer) ?></div>
            <div><?= nl2br(htmlspecialchars($transaksi->alamat_customer)) ?></div>
            <div>Up : <?= htmlspecialchars($transaksi->penerima_customer) ?></div>
        </div>
    </div>

    <div class="invoice-no">
        No. Faktur : <?= $transaksi->nomor_transaksi ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_qty = 0;
            $total_unit_price = 0;
            $grand_total = 0;
            if (!empty($transaksi_barang)) {
                foreach ($transaksi_barang as $item) { 
                    $total_qty += $item->jumlah_barang;
                    $total_unit_price += $item->harga_barang;
                    $total_harga = $item->jumlah_barang * $item->harga_barang;
                    $grand_total += $total_harga;
            ?>
                <tr>
                    <td class="text-center"><?= $item->kode_barang ?></td>
                    <td class="text-left"><?= $item->nama_barang ?></td>
                    <td class="text-center"><?= $item->nama_satuan ?></td>
                    <td class="text-center"><?= number_format($item->jumlah_barang, 0, ',', '.') ?></td>
                    <td class="text-right"><?= $this->req->rupiah($item->harga_barang) ?></td>
                    <td class="text-right"><?= $this->req->rupiah($total_harga) ?></td>
                </tr>
            <?php 
                }
            } 
            ?>
        </tbody>
        <tr class="total-row">
            <td colspan="3" class="text-center">TOTAL</td>
            <td class="text-center"><?= number_format($total_qty, 0, ',', '.') ?></td>
            <td class="text-right"><?= $this->req->rupiah($total_unit_price) ?></td>
            <td class="text-right"><?= $this->req->rupiah($grand_total) ?></td>
        </tr>
    </table>

    <div class="footer">
        <div class="signature-box">
            <div class="signature-title">Purchasing</div>
            <div class="signature-name"><?= $transaksi->nama_user?></div>
        </div>
        <div class="signature-box" style="width: 40%;">
            <div class="signature-date">Cirebon, <?= $this->req->dateIndo($transaksi->waktu_diterima) ?></div>
            <div class="signature-name-right"><?= htmlspecialchars($transaksi->penerima_customer) ?></div>
        </div>
    </div>
</div>

</body>
</html>
