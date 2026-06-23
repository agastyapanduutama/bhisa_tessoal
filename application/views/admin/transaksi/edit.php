<div class="card">
    <div class="card-header">
         <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left me-2"></i> Kembali ke menu sebelumnya</a>
        <h5 class="card-title">Edit Transaksi</h5>
    </div>
    <div class="card-body">
        <form id="formEditTransaksi">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Transaksi <span style="color:red">*</span></label>
                        <input type="text" name="nomor_transaksi" class="form-control" value="<?= $transaksi->nomor_transaksi ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Customer <span style="color:red">*</span></label>
                        <input type="text" name="nama_customer" class="form-control" value="<?= $transaksi->nama_customer ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Customer <span style="color:red">*</span></label>
                        <textarea name="alamat_customer" class="form-control" required><?= $transaksi->alamat_customer ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Penerima <span style="color:red">*</span></label>
                        <input type="text" name="penerima_customer" class="form-control" value="<?= $transaksi->penerima_customer ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Waktu Diterima <span style="color:red">*</span></label>
                        <input type="date" name="waktu_diterima" class="form-control" value="<?= $transaksi->waktu_diterima ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"><?= $transaksi->keterangan ?></textarea>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Data Barang</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="tableBarang">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th width="150">Jumlah</th>
                            <th width="100">
                                <button type="button" class="btn btn-sm btn-success" id="btnAddBarang"><i class="fas fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tbodyBarang">
                        <?php if (count($transaksi_barang) > 0) { ?>
                            <?php foreach ($transaksi_barang as $index => $tb) { ?>
                                <tr>
                                    <td>
                                        <select name="id_barang[]" class="form-control select2_transaksi" required>
                                            <option value="">-- Pilih Barang --</option>
                                            <?php foreach ($barang as $b) { ?>
                                                <option value="<?= $b->id ?>" <?= $b->id == $tb->id_barang ? 'selected' : '' ?>><?= $b->kode_barang ?> - <?= $b->nama_barang ?> (<?= $b->nama_satuan ?>)</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_barang[]" class="form-control" value="<?= $tb->jumlah_barang ?>" min="1" required>
                                    </td>
                                    <td>
                                        <?php if ($index > 0) { ?>
                                            <button type="button" class="btn btn-sm btn-danger btnRemoveBarang"><i class="fas fa-trash"></i></button>
                                        <?php } else { ?>
                                            <!-- The first row shouldn't typically be completely deleted to leave an empty form, but we can allow it -->
                                            <button type="button" class="btn btn-sm btn-danger btnRemoveBarang"><i class="fas fa-trash"></i></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td>
                                    <select name="id_barang[]" class="form-control select2_transaksi" required>
                                        <option value="">-- Pilih Barang --</option>
                                        <?php foreach ($barang as $b) { ?>
                                            <option value="<?= $b->id ?>"><?= $b->kode_barang ?> - <?= $b->nama_barang ?> (<?= $b->nama_satuan ?>)</option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="jumlah_barang[]" class="form-control" min="1" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger btnRemoveBarang"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary" id="btnSave">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    var opsiBarang = `<option value="">-- Pilih Barang --</option>` + 
    `<?php foreach ($barang as $b) { ?>
        <option value="<?= $b->id ?>"><?= $b->kode_barang ?> - <?= $b->nama_barang ?> (<?= $b->nama_satuan ?>)</option>
    <?php } ?>`;
</script>
