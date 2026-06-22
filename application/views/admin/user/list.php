    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Unit </label>
                        <select name="id_unit_filter" class="form-control" id="id_unit_filter">
                            <option value="all">Semua Unit/Bagian</option>
                            <?php foreach ($unit as $u) {
                                echo "<option value='" . $u->id . "'>" . $u->nama_unit . "</option>";
                            } ?>

                        </select>
                    </div>
                </div>
                <div class="col-3 mt-5">
                    <button type="button" id="filter" class="btn btn-primary mt-1">Filter Data</button>
                </div>
            </div>
            <div class="card-title">

            </div>
            <div class='table-responsive'>
                <table id="list_user" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Unit</td>
                            <td>Nama user</td>
                            <td>Username</td>
                            <td>Level</td>
                            <td>Keterangan</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <div class="modal fade modalna" tabindex="-1" role="dialog" id="modalTambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAdduser">
                    <div class="modal-body">
                        <label for="">Label yang memililiki tanda <span style="color:red">*</span> Tidak boleh kosong</label>
                        <br><br><br>

                        <div class="form-group">
                            <label>Nama user <span style="color:red">*</span> </label>
                            <input type="text" name="nama_user" id="nama_user" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username <span style="color:red">*</span> </label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>password <span style="color:red">*</span> </label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Level <span style="color:red">*</span> </label>
                            <select name="level" class="form-control select2" id="level">
                                <option value="1">Admin</option>
                                <option value="2">Perencana</option>
                                <option value="3">Pengadaan</option>
                                <option value="4">Penerimaan</option>
                                <option value="5">Pengurus Stok</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Unit <span style="color:red">*</span> </label>
                            <select name="id_unit" class="form-control select2" id="id_unit">
                                <?php foreach ($unit as $u) {
                                    echo "<option value='" . $u->id . "'>" . $u->nama_unit . "</option>";
                                } ?>
                                <option value="0">Semua Unit/Bagian</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan " class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modalnaedit" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEdituser">
                    <div class="modal-body">

                        <label for="">Label yang memililiki tanda <span style="color:red">*</span> Tidak boleh kosong</label>
                        <br><br><br>

                        <input type="hidden" name="id" id="idData">



                        <div class="form-group">
                            <label>Nama user <span style="color:red">*</span> </label>
                            <input type="text" name="nama_user" id="nama_user1" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username <span style="color:red">*</span> </label>
                            <input type="text" name="username" id="username1" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>password (Abaikan jika tidak diubah) </label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Level <span style="color:red">*</span> </label>
                            <select name="level" class="form-control select2edit" id="level1">
                                <option value="1">Admin</option>
                                <option value="2">Perencana</option>
                                <option value="3">Pengadaan</option>
                                <option value="4">Penerimaan</option>
                                <option value="5">Pengurus Stok</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Unit <span style="color:red">*</span> </label>
                            <select name="id_unit" class="form-control select2edit" id="id_unit1">
                                <?php foreach ($unit as $u) {
                                    echo "<option value='" . $u->id . "'>" . $u->nama_unit . "</option>";
                                } ?>

                                <option value="0">Semua Unit/Bagian</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan1" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--  -->