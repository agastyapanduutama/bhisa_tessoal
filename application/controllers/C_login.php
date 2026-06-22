<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_login', 'login');
        $this->load->helper('cookie');
    }

    public function index()
    {
        show_404();
    }


    public function login()
    {

        if (isset($_COOKIE['bhisa'])) {

            $id = $_COOKIE['bhisa'];

            if ($this->login->cekDataById([$this->req->encKey('id') => $id]) == true) {
                $userData = $this->login->getData();
                if ($userData->status == 1) {
                    $session = array(
                        'bhisa_akses'        => true,
                        'id_user'           => $userData->id,
                        'id_jabatan'         => $userData->id_jabatan,
                        'username'          => $userData->username,
                        'nama_user'         => $userData->nama_user,
                        'logged_in'         => true
                    );
                    $this->session->set_userdata($session);
                    $this->input->set_cookie('bhisa', $this->req->enc_string(json_encode($session)), time() + (86400 * 30));
                    redirect('admin/home', 'refresh');
                } else {
                    $this->session->set_flashdata('warning', "Akun kamu tidak aktif");
                    redirect('admin/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('warning', "Sesi masuk anda sudah habis silakan login kembali");
                $data = array(
                    'title' => "Masuk Akun",
                    'content' => 'admin/v_login'
                );
                $this->load->view('admin/v_login', $data, false);
            }
        } else {

            $data = array(
                'title' => "Masuk Akun",
                'content' => 'admin/v_login'
            );
            $this->load->view('admin/v_login', $data, false);
        }
    }



    function aksi()
    {

        $user = $this->input->post('username');
        $pass = $this->input->post('password');
        $where = array(
            'username' => $user,
            'password' => md5($pass)
        );

        // $this->req->print($where);

        if ($this->login->cek($where) == true) {
            $userData = $this->login->getData();
            if ($userData->status == 1) {
                $session = array(
                    'bhisa_akses'    => true,
                    'id_user'        => $userData->id,
                    'id_jabatan'        => $userData->id_jabatan,
                    'username'       => $userData->username,
                    'nama_user'      => $userData->nama_user,
                    'logged_in'      => true,

                );
                // var_dump($session);
                $this->session->set_userdata($session);
                $this->input->set_cookie('bhisa', $this->req->acak($userData->id), time() + (86400 * 30));

                redirect('admin/home', 'refresh');
            } else {

                // $this->req->print($_POST);
                $this->session->set_flashdata('warning', "Akun kamu tidak aktif");
                redirect('admin/login', 'refresh');
            }
        } else {

            $this->session->set_flashdata('warning', "Username atau Password Salah");
            redirect('admin/login', 'refresh');
        }
    }





    public function logout()
    {

        unset($_COOKIE['bhisa']);
        unset($_COOKIE['bhisa']);

        setcookie('bhisa', null, -1, '/');
        setcookie('bhisa', null, -1, '/');

        // Menghapus cookie dari domain utama dan semua subdomain
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/', $_SERVER['SERVER_NAME'], false, true);
        }
        
        $this->session->sess_destroy();
        redirect(base_url('admin/login'));
    }
}
