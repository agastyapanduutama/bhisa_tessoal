<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model {

    function get_total_barang()
    {
        $this->db->where('status', 1);
        return $this->db->count_all_results('t_barang');
    }

    function get_total_transaksi()
    {
        return $this->db->count_all_results('t_transaksi');
    }

    function get_nominal_transaksi()
    {
        $this->db->select('SUM(t_transaksi_barang.jumlah_barang * t_barang.harga_barang) as total_nominal');
        $this->db->from('t_transaksi_barang');
        $this->db->join('t_barang', 't_transaksi_barang.id_barang = t_barang.id', 'left');
        return $this->db->get()->row()->total_nominal;
    }

    function get_chart_data_array()
    {
        $this->db->select('MONTH(waktu_diterima) as month, COUNT(*) as count');
        $this->db->from('t_transaksi');
        $this->db->where('YEAR(waktu_diterima)', date('Y'));
        $this->db->group_by('MONTH(waktu_diterima)');
        $results = $this->db->get()->result();

        $data = array_fill(0, 12, 0);
        foreach ($results as $row) {
            $data[$row->month - 1] = (int) $row->count;
        }
        return $data;
    }

    function get_chart_nominal_array()
    {
        $this->db->select('MONTH(t.waktu_diterima) as month, SUM(tb.jumlah_barang * b.harga_barang) as nominal');
        $this->db->from('t_transaksi_barang tb');
        $this->db->join('t_transaksi t', 'tb.id_transaksi = t.id');
        $this->db->join('t_barang b', 'tb.id_barang = b.id');
        $this->db->where('YEAR(t.waktu_diterima)', date('Y'));
        $this->db->group_by('MONTH(t.waktu_diterima)');
        $results = $this->db->get()->result();

        $data = array_fill(0, 12, 0);
        foreach ($results as $row) {
            $data[$row->month - 1] = (int) $row->nominal;
        }
        return $data;
    }

}

/* End of file M_home.php */
