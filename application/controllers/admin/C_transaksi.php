<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_transaksi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login


        $this->load->model('admin/M_transaksi', 'transaksi');
    }

    public function list()
    {
        $data = array(
            'title'  => 'Data transaksi',
            'menu'   => 'transaksi',
            'script' => 'transaksi',
            'content' => 'admin/transaksi/list',
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }

    public function add()
    {
        $barang = $this->transaksi->data_barang();

        $data = array(
            'title'  => 'Tambah Transaksi',
            'menu'   => 'transaksi',
            'script' => 'transaksi',
            'content' => 'admin/transaksi/add',
            'barang' => $barang
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }

    public function edit($idtransaksi)
    {
        
        $transaksi = $this->transaksi->get($idtransaksi);
        $transaksi_barang = $this->transaksi->data_transaksi_barang($idtransaksi);
        $barang = $this->transaksi->data_barang();

        $data = array(
            'title'  => 'Edit Transaksi',
            'menu'   => 'transaksi',
            'script' => 'transaksi',
            'content' => 'admin/transaksi/edit',
            'id'     => $idtransaksi,
            'transaksi' => $transaksi,
            'transaksi_barang' => $transaksi_barang,
            'barang' => $barang
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }

    public function detail($idtransaksi)
    {
        $transaksi = $this->transaksi->get($idtransaksi);
        $transaksi_barang = $this->transaksi->data_transaksi_barang($idtransaksi);

        $data = array(
            'title'  => 'Detail Transaksi',
            'menu'   => 'transaksi',
            'script' => 'transaksi',
            'content' => 'admin/transaksi/detail',
            'id'     => $idtransaksi,
            'transaksi' => $transaksi,
            'transaksi_barang' => $transaksi_barang
        );

        $this->load->view('admin/templates/template', $data, FALSE);
    }

    public function print_transaksi($idtransaksi)
    {
        $transaksi = $this->transaksi->get($idtransaksi);
        $transaksi_barang = $this->transaksi->data_transaksi_barang($idtransaksi);

        $data = array(
            'title'  => 'Print Transaksi',
            'transaksi' => $transaksi,
            'transaksi_barang' => $transaksi_barang
        );

        $this->load->view('admin/transaksi/print_transaksi', $data, FALSE);
    }


    function gettransaksi()
    {
        echo json_encode($this->transaksi->data_transaksi());
    }


    function data()
    {
        error_reporting(0);
        $list = $this->transaksi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            // $idNa = $this->req->acak($field->id);
            $idNa = $field->id;


            // transaksi hanya bisa diubah jika user tersebut yang membuatnya

            if($field->id_user == $this->session->userdata('id_user') || $this->session->userdata('is_admin') == 1){
                $button = "
                <a href='".base_url('admin/transaksi/detail/'.$idNa)."' class='btn btn-info btn-sm' title='Detail/Print Data'><i class='fas fa-eye'></i></a>
                <a href='".base_url('admin/transaksi/edit/'.$idNa)."' class='btn btn-warning btn-sm' title='Edit Data'><i class='fas fa-pencil-alt'></i></a>";
            }else{
                $button = "
                <a href='".base_url('admin/transaksi/detail/'.$idNa)."' class='btn btn-info btn-sm' title='Detail/Print Data'><i class='fas fa-eye'></i></a>";
            }

          
            if ($this->session->userdata('is_admin') == 1) {
                $button .= " <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Data'><i class='fas fa-trash-alt'></i></button>";
            }



            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor_transaksi;
            $row[] = $field->nama_customer;
            $row[] = $field->penerima_customer;
            $row[] = $this->req->dateIndo($field->waktu_diterima);
            $row[] = $field->keterangan;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transaksi->count_all(),
            "recordsFiltered" => $this->transaksi->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

  

    function insert()
    {

        
        $lastData = $this->db->select('id')->order_by('id', 'DESC')->limit(1)->get('t_transaksi')->row();
        $lastId = ($lastData) ? $lastData->id : 0;
        $nextId = $lastId + 1;
        $nomor_transaksi = 'TRX-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $custom = array(
            'id_barang'      => false,
            'jumlah_barang' => false,
            'nomor_transaksi' => $nomor_transaksi,
            'id_user'         => $this->session->userdata('id_user'),
            'created_by'      => $this->session->userdata('id_user'),
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'updated_by'     => $this->session->userdata('id_user'),
        );

        @$data = $this->req->all($custom);

        $this->db->insert('t_transaksi', $data);
        $id_transaksi = $this->db->insert_id();

        $id_barang = $this->input->post('id_barang');
        $jumlah_barang = $this->input->post('jumlah_barang');

        if (!empty($id_barang)) {
            $data_barang = array();
            for ($i = 0; $i < count($id_barang); $i++) {
                if (!empty($id_barang[$i]) && !empty($jumlah_barang[$i])) {
                    $data_barang[] = array(
                        'id_transaksi' => $id_transaksi,
                        'id_barang'    => $id_barang[$i],
                        'jumlah_barang'=> $jumlah_barang[$i],
                        'created_by'   => $this->session->userdata('id_user'),
                        'created_at'   => date('Y-m-d H:i:s'),
                        'updated_by'     => $this->session->userdata('id_user'),
                        'updated_at'     => date('Y-m-d H:i:s'),
                    );
                }
            }
            if (!empty($data_barang)) {
                $this->db->insert_batch('t_transaksi_barang', $data_barang);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal menambahkan data !'
            );
        } else {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil menambahkan data !'
            );
        }
        echo json_encode($msg);
    }

    function set($id, $action)
    {
        if ($action == 'on') {
            if ($this->transaksi->update(['status' => '1'], $this->req->id($id)) == true) {
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
            if ($this->transaksi->update(['status' => '0'], $this->req->id($id)) == true) {
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
            if ($this->transaksi->update(['password' => $this->req->acak('123')], $this->req->id($id)) == true) {
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
        $id = $this->input->post('id');

        $custom = [
            'updated_by' => $this->session->userdata('id_user'),
            'updated_at' => date('Y-m-d H:i:s'),
            'id_transaksi' => false,
            'id_barang'     => false,
            'jumlah_barang' => false,
        ];

        @$data = $this->req->all($custom);

        $this->db->where('id', $id);
        $this->db->update('t_transaksi', $data);

        $this->db->where('id_transaksi', $id);
        $this->db->delete('t_transaksi_barang');

        $id_barang = $this->input->post('id_barang');
        $jumlah_barang = $this->input->post('jumlah_barang');

        if (!empty($id_barang)) {
            $data_barang = array();
            for ($i = 0; $i < count($id_barang); $i++) {
                if (!empty($id_barang[$i]) && !empty($jumlah_barang[$i])) {
                    $data_barang[] = array(
                        'id_transaksi' => $id,
                        'id_barang'    => $id_barang[$i],
                        'jumlah_barang'=> $jumlah_barang[$i],
                        'id_user'      => $this->session->userdata('id_user'),
                        'created_by'   => $this->session->userdata('id_user'),
                        'created_at'   => date('Y-m-d H:i:s')
                    );
                }
            }
            if (!empty($data_barang)) {
                $this->db->insert_batch('t_transaksi_barang', $data_barang);
            }
        }


        $row_transaksi = $this->db->affected_rows();
        $row_transaksi_barang = $this->db->affected_rows();

        if ($row_transaksi == 0 && $row_transaksi_barang == 0) {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal mengubah data !'
            );
        } else {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil mengubah data !'
            );
        }
        echo json_encode($msg);
    }

    function delete($id)
    {
        if ($this->session->userdata('is_admin') != 1) {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Hanya admin yang dapat menghapus data !'
            );
            echo json_encode($msg);
            return;
        }

        if ($this->transaksi->delete($this->req->id($id)) == true) {
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
