<?php

class M_transaksi extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_transaksi";

        $this->column_order = array(
            null,
            't_transaksi.nomor_transaksi',
            't_transaksi.nama_customer',
            't_transaksi.alamat_customer',
            't_transaksi.penerima_customer',
            't_transaksi.waktu_diterima',
            't_transaksi.keterangan',
            't_user.nama_user',
            't_user_update.nama_user' 
        );

        $this->column_search = array(
            't_transaksi.nomor_transaksi',
            't_transaksi.nama_customer',
            't_transaksi.alamat_customer',
            't_transaksi.penerima_customer',
            't_transaksi.waktu_diterima',
            't_transaksi.keterangan',
            't_user.nama_user',
            't_user_update.nama_user' 
        );

        $this->order = array('t_transaksi.id' => 'desc');
    }

    private function _get_datatables_query()
    {
        $this->db->select('t_transaksi.*, t_user.nama_user as nama_user, t_user_update.nama_user as nama_user_update');
        $this->db->from($this->table);
        $this->db->join('t_user', 't_transaksi.id_user = t_user.id', 'left');

        $this->db->join('t_user as t_user_update', 't_transaksi.updated_by = t_user_update.id', 'left');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function cekPerubahan()
    {
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->cekPerubahan();
    }

    function get($id)
    {
        $this->db->select('t_transaksi.*, t_user.nama_user as nama_user, t_user_update.nama_user as nama_user_update');
        $this->db->from($this->table);
        $this->db->join('t_user', 't_transaksi.id_user = t_user.id', 'left');

        $this->db->join('t_user as t_user_update', 't_transaksi.updated_by = t_user_update.id', 'left');
        $this->db->where('t_transaksi.id', $id);
        return $this->db->get()->row();
    }

    function update($data, $where)
    {
        $this->db->where($where);
        $this->db->update('t_transaksi', $data);
        return $this->cekPerubahan();
    }

    function delete($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table);
        return $this->cekPerubahan();
    }

    function data_transaksi()
    {
        $this->db->select('*');
        $this->db->from('t_transaksi');
        $this->db->join('t_satuan', 't_transaksi.id_satuan = t_satuan.id', 'left');
        $this->db->order_by('t_transaksi.nama_transaksi', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function data_transaksi_barang($idtransaksi){
        $this->db->select('t_transaksi_barang.*, t_barang.nama_barang, t_satuan.nama_satuan, t_barang.kode_barang, t_barang.harga_barang');
        $this->db->from('t_transaksi_barang');
        $this->db->join('t_barang', 't_transaksi_barang.id_barang = t_barang.id', 'left');
        $this->db->join('t_satuan', 't_barang.id_satuan = t_satuan.id', 'left');
        $this->db->where('t_transaksi_barang.id_transaksi', $idtransaksi);
        return  $this->db->get()->result();
    }

    function data_barang(){
        $this->db->select('t_barang.*, t_satuan.nama_satuan');
        $this->db->from('t_barang');
        $this->db->join('t_satuan', 't_barang.id_satuan = t_satuan.id', 'left');
        $this->db->where('t_barang.status', 1);
        return  $this->db->get()->result();
    }

    
}