<div class="card">
    <div class="card-header">
        <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left me-2"></i> Kembali ke menu sebelumnya</a>
        <a href="<?= base_url('admin/transaksi/print_transaksi/'.$id) ?>" target="_blank" class="btn btn-warning mb-3"><i class="fas fa-print"></i> Cetak Faktur</a>
        <h5 class="card-title mb-0">Detail Transaksi</h5>
    </div>
    <div class="card-body">
        
        <div class="row mb-4 mt-3">
            <div class="col-sm-6">
                <h5 class="mb-3">Informasi Transaksi:</h5>
                <div><strong>No. Faktur:</strong> <?= $transaksi->nomor_transaksi ?></div>
                <div><strong>Waktu Diterima:</strong> <?= $this->req->dateIndo($transaksi->waktu_diterima) ?></div>
                <div><strong>Keterangan:</strong> <?= $transaksi->keterangan ?></div>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h5 class="mb-3">Kepada Yth:</h5>
                <div><strong><?= $transaksi->nama_customer ?></strong></div>
                <div><?= nl2br($transaksi->alamat_customer) ?></div>
                <div>Up : <?= $transaksi->penerima_customer ?></div>
            </div>
        </div>

        <div class="table-responsive-sm">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Kode</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Total Harga</th>
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
                            <td><?= $item->nama_barang ?></td>
                            <td><?= $item->nama_satuan ?></td>
                            <td class="text-center"><?= number_format($item->jumlah_barang, 0, ',', '.') ?></td>
                            <td class="text-right"><?= $this->req->rupiah($item->harga_barang) ?></td>
                            <td class="text-right"><?= $this->req->rupiah($total_harga) ?></td>
                        </tr>
                    <?php 
                        }
                    } 
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">TOTAL</th>
                        <th class="text-center"><?= number_format($total_qty, 0, ',', '.') ?></th>
                        <th class="text-right"><?= $this->req->rupiah($total_unit_price) ?></th>
                        <th class="text-right"><?= $this->req->rupiah($grand_total) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
