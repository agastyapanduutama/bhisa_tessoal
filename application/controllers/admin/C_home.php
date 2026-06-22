<?php


defined('BASEPATH') or exit('No direct script access allowed');

class C_home extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Home',
            'content' => 'admin/v_home'
        ];

        $this->load->view('admin/templates/template', $data, FALSE);
    }
}

/* End of file C_home.php */
