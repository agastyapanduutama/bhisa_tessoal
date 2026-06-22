<?php

class M_login extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function cek($data)
    {
        $cek = $this->db->get_where('t_user', $data)->num_rows();
        if ($cek > 0) {
            return true;
        } else {
            return false;
        }
    }

    function cekDataById($data)
    {
        $cek = $this->db->get_where('t_user', $data)->num_rows();
        if ($cek > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getData()
    {
        return $this->db->query($this->db->last_query())->row();
    }

    public function cekMahasiswa($nim)
    {
        return $this->db->get_where('t_mahasiswa', ['nim_mahasiswa' => $nim])->num_rows();
    }
    
    public function dataMahasiswa($nim)
    {
        return $this->db->get_where('t_mahasiswa', ['nim_mahasiswa' => $nim])->row();
    }

    public function cekAkun($nim)
    {
        return $this->db->get_where('t_user', ['username' => $nim])->num_rows();
    }

    public function cekAkunAda()
    {
        
    }
}
