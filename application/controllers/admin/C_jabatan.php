<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_jabatan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login


        $this->load->model('admin/M_jabatan', 'jabatan');
    }

    public function list()
    {
        $data = array(
            'title'  => 'Data jabatan',
            'menu'   => 'master',
            'script' => 'jabatan',
            'content' => 'admin/jabatan/list'
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }


    function getjabatan()
    {
        echo json_encode($this->jabatan->data_jabatan());
    }


    function data()
    {
        error_reporting(0);
        $list = $this->jabatan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            // $idNa = $field->id;


            $button = "
            <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Data'><i class='fas fa-trash-alt'></i></button>
            <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa' title='Edit Data'><i class='fas fa-pencil-alt'></i></button>";

            $status = ($field->status == 1) ? "<button class='btn btn-success btn-sm' id='set' data-id='$idNa' data-action='off' title='Nonaktifkan data'><i class='fas fa-toggle-on'></i></button>" : "<button class='btn btn-danger btn-sm' id='set' data-id='$idNa' data-action='on' title='Aktifkan data'><i class='fas fa-toggle-off'></i></button>";

            $aksesAdmin = ($field->is_admin == 1) ? "<span class='badge bg-success'>Ya</span>" : "<span class='badge bg-danger'>Tidak</span>";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $aksesAdmin;
            $row[] = $field->nama_jabatan;
            $row[] = $field->keterangan;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatan->count_all(),
            "recordsFiltered" => $this->jabatan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->jabatan->get($id);
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
        if ($this->jabatan->insert($data) == true) {
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
            if ($this->jabatan->update(['status' => '1'], $this->req->id($id)) == true) {
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
            if ($this->jabatan->update(['status' => '0'], $this->req->id($id)) == true) {
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
            if ($this->jabatan->update(['password' => $this->req->acak('123')], $this->req->id($id)) == true) {
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
        if ($this->jabatan->update($data, $this->req->id($id)) == true) {
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
        if ($this->jabatan->delete($this->req->id($id)) == true) {
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
