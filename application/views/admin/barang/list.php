    <div class="card">
        <div class="card-header">
            <?php if($_SESSION['is_admin'] == 1):?>
            <button class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
            <?php endif?>
        </div>
        <div class="card-body">
            <div class="card-title">
                Data Barang
            </div>
            <div class='table-responsive'>
                <table id="list_barang" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Kode Barang</td>
                            <td>Nama Barang</td>
                            <td>Harga Barang</td>
                            <td>Satuan</td>
                            <td>Keterangan</td>
                            <td>Status</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah barang</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddbarang">
                    <div class="modal-body">
                        <label for="">Label yang memililiki tanda <span style="color:red">*</span> Tidak boleh kosong</label>
                        <br><br><br>

                        <div class="form-group">
                            <label>Nama barang <span style="color:red">*</span> </label>
                            <input type="text" name="nama_barang" id="barang" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="number" name="harga_barang" id="harga_barang " class="form-control">
                        </div>


                        <div class="form-group">
                            <label>Satuan</label>
                            <select name="id_satuan" id="id_satuan" class="form-control">
                                <option value="">Pilih Satuan</option>
                                <?php foreach ($satuan as $s): ?>
                                    <option value="<?= $s->id ?>"><?= $s->nama_satuan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan " class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah barang</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditbarang">
                    <div class="modal-body">

                        <label for="">Label yang memililiki tanda <span style="color:red">*</span> Tidak boleh kosong</label>
                        <br><br><br>

                        <input type="hidden" name="id" id="idData">


                        <div class="form-group">
                            <label>Nama barang <span style="color:red">*</span> </label>
                            <input type="text" name="nama_barang" id="nama_barang1" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Barang<span style="color:red">*</span></label>
                            <input type="number" name="harga_barang" id="harga_barang1" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Satuan</label>
                            <select name="id_satuan" id="id_satuan1" class="form-control">
                                <option value="">Pilih Satuan</option>
                                <?php foreach ($satuan as $s): ?>
                                    <option value="<?= $s->id ?>"><?= $s->nama_satuan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan1" class="form-control">
                        </div>


                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--  -->