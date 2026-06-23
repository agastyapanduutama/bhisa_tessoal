<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_barang extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login


        $this->load->model('admin/M_barang', 'barang');
    }

    public function list()
    {

        $satuan = $this->db->get_where('t_satuan', ['status' => 1])->result();

        $data = array(
            'title'  => 'Data barang',
            'menu'   => 'master',
            'script' => 'barang',
            'content' => 'admin/barang/list',
            'satuan' => $satuan
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }


    function getbarang()
    {
        echo json_encode($this->barang->data_barang());
    }


    function data()
    {
        error_reporting(0);
        $list = $this->barang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            // $idNa = $field->id;

            
            if($_SESSION['is_admin'] == 1){
                $button = "
                <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Data'><i class='fas fa-trash-alt'></i></button>
                <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa' title='Edit Data'><i class='fas fa-pencil-alt'></i></button>";
                $status = ($field->status == 1) ? "<button class='btn btn-success btn-sm' id='set' data-id='$idNa' data-action='off' title='Nonaktifkan data'><i class='fas fa-toggle-on'></i></button>" : "<button class='btn btn-danger btn-sm' id='set' data-id='$idNa' data-action='on' title='Aktifkan data'><i class='fas fa-toggle-off'></i></button>";
            }else{
                $button = '';
                $status = ($field->status == 1) ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Nonaktif</span>";
            }

          


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->kode_barang;
            $row[] = $field->nama_barang;
            $row[] = $this->req->rupiah($field->harga_barang);
            $row[] = $field->nama_satuan;
            $row[] = $field->keterangan;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barang->count_all(),
            "recordsFiltered" => $this->barang->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->barang->get($id);
        foreach ($data as $key => $value) {
            if (strtolower($key) == 'id') {
                $data->$key = $this->req->acak($value);
            }
        }
        echo json_encode($data);
    }

    function insert()
    {
        $lastData = $this->db->select('id')->order_by('id', 'DESC')->limit(1)->get('t_barang')->row();
        $lastId = ($lastData) ? $lastData->id : 0;
        $nextId = $lastId + 1;
        $kodebarangna = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $custom = [
            'kode_barang' => 'PR' . $kodebarangna
        ];

        $data = $this->req->all($custom);

        if ($this->barang->insert($data) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil menambahkan data !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal menambahkan data !'
            );
        }
        echo json_encode($msg);
    }

    function set($id, $action)
    {
        if ($action == 'on') {
            if ($this->barang->update(['status' => '1'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Mengaktifkan Akun !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal menambahkan data !'
                );
            }
            echo json_encode($msg);
        } elseif ($action == 'off') {
            if ($this->barang->update(['status' => '0'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Me-nonaktifkan Akun !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal Me-nonaktifkan data !'
                );
            }
            echo json_encode($msg);
        } elseif ($action == 'reset') {
            if ($this->barang->update(['password' => $this->req->acak('123')], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Me-reset Akun !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal Me-reset data !'
                );
            }
            echo json_encode($msg);
        }
    }


    function update()
    {

        // $this->req->print($_POST);


        $id = $this->input->post('id');
        $data = $this->req->all(['id' => false, 'kode_barang' => false]);
        if ($this->barang->update($data, $this->req->id($id)) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil mengubah data !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal mengubah data !'
            );
        }
        // echo $this->db->last_query();
        echo json_encode($msg);
    }

    function delete($id)
    {
        if ($this->barang->delete($this->req->id($id)) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil menghapus data !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal menghapus data !'
            );
        }
        echo json_encode($msg);
    }
}
