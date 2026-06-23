    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>


        </div>
        <div class="card-body">
            <div class="card-title">
                Data jabatan
            </div>
            <div class='table-responsive'>
                <table id="list_jabatan" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Akses Admin</td>
                            <td>Nama jabatan</td>
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
                    <h5 class="modal-title">Tambah jabatan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddjabatan">
                    <div class="modal-body">
                        <label for="">Label yang memililiki tanda <span style="color:red">*</span> Tidak boleh kosong</label>
                        <br><br><br>

                        <div class="form-group">
                            <label>Nama jabatan <span style="color:red">*</span> </label>
                            <input type="text" name="nama_jabatan" id="jabatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan " class="form-control">
                        </div>


                        <div class="form-group">
                            <label>Apakah admin <span style="color:red">*</span> </label>
                            <select name="is_admin" class="form-control" id="is_admin">
                                <option value="1">Ya</option>
                                <option value="0" selected>Tidak</option>
                            </select>
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
                    <h5 class="modal-title">Tambah jabatan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditjabatan">
                    <div class="modal-body">

                        <label for="">Label yang memililiki tanda <span style="color:red">*</span> Tidak boleh kosong</label>
                        <br><br><br>

                        <input type="hidden" name="id" id="idData">


                        <div class="form-group">
                            <label>Nama jabatan <span style="color:red">*</span> </label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan1" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan1" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>Apakah admin <span style="color:red">*</span> </label>
                            <select name="is_admin" class="form-control" id="is_admin1">
                                <option value="1">Ya</option>
                                <option value="0" selected>Tidak</option>
                            </select>
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