<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_satuan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login


        $this->load->model('admin/M_satuan', 'satuan');
    }

    public function list()
    {
       
        

        $data = array(
            // 'satuan' => $satuan,
            'title'  => 'Data satuan',
            'menu'   => 'master',
            'script' => 'satuan',
            'content' => 'admin/satuan/list'
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }


    function getsatuan()
    {
        echo json_encode($this->satuan->data_satuan());
    }


    function data()
    {
        error_reporting(0);
        $list = $this->satuan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            // $idNa = $field->id;


            $button = "
            <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Data'><i class='fas fa-trash-alt'></i></button>
            <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa' title='Edit Data'><i class='fas fa-pencil-alt'></i></button>";

            $status = ($field->status == 1) ? "<button class='btn btn-success btn-sm' id='set' data-id='$idNa' data-action='off' title='Nonaktifkan data'><i class='fas fa-toggle-on'></i></button>" : "<button class='btn btn-danger btn-sm' id='set' data-id='$idNa' data-action='on' title='Aktifkan data'><i class='fas fa-toggle-off'></i></button>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nama_satuan;
            $row[] = $field->keterangan;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->satuan->count_all(),
            "recordsFiltered" => $this->satuan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->satuan->get($id);
        foreach ($data as $key => $value) {
            if (strtolower($key) == 'id') {
                $data->$key = $this->req->acak($value);
            }
        }
        echo json_encode($data);
    }

    function insert()
    {
        $data = $this->req->all();
        if ($this->satuan->insert($data) == true) {
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
            if ($this->satuan->update(['status' => '1'], $this->req->id($id)) == true) {
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
            if ($this->satuan->update(['status' => '0'], $this->req->id($id)) == true) {
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
            if ($this->satuan->update(['password' => $this->req->acak('123')], $this->req->id($id)) == true) {
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
        $data = $this->req->all(['id' => false]);
        if ($this->satuan->update($data, $this->req->id($id)) == true) {
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
        if ($this->satuan->delete($this->req->id($id)) == true) {
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
