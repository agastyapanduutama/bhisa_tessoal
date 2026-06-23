<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_user extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login


        $this->load->model('admin/M_user', 'user');
    }

    public function list()
    {


        $jabatan = $this->db->get_where('t_jabatan', ['status' => 1])->result();

        

        $data = array(
            'jabatan'    => $jabatan,
            'title'  => 'Data user',
            'script' => 'user',
            'content' => 'admin/user/list'
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }


    function getuser()
    {
        echo json_encode($this->user->data_user());
    }


    function data()
    {

        $id_jabatan = ($this->input->post('id_jabatan') == null || $this->input->post('id_jabatan') == "all") ? null : $this->input->post('id_jabatan');

        error_reporting(0);
        $list = $this->user->get_datatables($id_jabatan);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);


            $button = "
            <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Data'><i class='fas fa-trash-alt'></i></button>
            <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa' title='Edit Data'><i class='fas fa-pencil-alt'></i></button>";

            $status = ($field->status == 1) ? "<button class='btn btn-success btn-sm' id='set' data-id='$idNa' data-action='off' title='Nonaktifkan Akun'><i class='fas fa-toggle-on'></i></button>" : "<button class='btn btn-danger btn-sm' id='set' data-id='$idNa' data-action='on' title='Aktifkan Akun'><i class='fas fa-toggle-off'></i></button>";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nama_jabatan;
            $row[] = $field->nama_user;
            $row[] = $field->username;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all($id_jabatan),
            "recordsFiltered" => $this->user->count_filtered($id_jabatan),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->user->get($id);
        foreach ($data as $key => $value) {
            if (strtolower($key) == 'id') {
                $data->$key = $this->req->acak($value);
            }
        }
        echo json_encode($data);
    }

    function insert()
    {

        // password menjadi md5
        

        $data = $this->req->all(
            ['password' => md5($_POST['password'])]
        );
        
        if ($this->user->insert($data) == true) {
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
            if ($this->user->update(['status' => '1'], $this->req->id($id)) == true) {
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
            if ($this->user->update(['status' => '0'], $this->req->id($id)) == true) {
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
            if ($this->user->update(['password' => $this->req->acak('123')], $this->req->id($id)) == true) {
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


        // jika password tidak diisi maka false jika ada maka rubah jadi md5
        if (!empty($_POST['password'])) {
            $_POST['password'] = md5($_POST['password']);
        }else{
            unset($_POST['password']);
        }


        $id = $this->input->post('id');
        $data = $this->req->all(['id' => false]);
        if ($this->user->update($data, $this->req->id($id)) == true) {
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
        if ($this->user->delete($this->req->id($id)) == true) {
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
