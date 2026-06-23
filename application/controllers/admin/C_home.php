<?php


defined('BASEPATH') or exit('No direct script access allowed');

class C_home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/M_home', 'home');
    }

    public function index()
    {
        $total_barang = $this->home->get_total_barang();
        $total_transaksi = $this->home->get_total_transaksi();
        $total_nominal = $this->home->get_nominal_transaksi();

        $chart_data = $this->home->get_chart_data_array();
        $chart_nominal = $this->home->get_chart_nominal_array();

        $data = [
            'title' => 'Dashboard',
            'content' => 'admin/v_home',
            'total_barang' => $total_barang,
            'total_transaksi' => $total_transaksi,
            'total_nominal' => $total_nominal ? $total_nominal : 0,
            'chart_data' => json_encode($chart_data),
            'chart_nominal' => json_encode($chart_nominal)
        ];

        $this->load->view('admin/templates/template', $data, FALSE);
    }
}

/* End of file C_home.php */
