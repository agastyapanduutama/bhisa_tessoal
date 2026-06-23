<?php

class M_barang extends CI_Model
{


    function __construct()
    {
        parent::__construct();
        $this->table = "t_barang";
        $this->column_order = array(null, 't_barang.kode_barang', 't_barang.nama_barang', 't_barang.keterangan','t_barang.status','t_satuan.nama_satuan');
        $this->column_search = array('t_barang.kode_barang', 't_barang.nama_barang', 't_barang.keterangan','t_barang.status','t_satuan.nama_satuan');
        $this->order = array('t_barang.id' => 'desc');
    }

    private function _get_datatables_query()
    {

        $this->db->select('t_barang.*, t_satuan.nama_satuan');
        $this->db->from($this->table);
        $this->db->join('t_satuan', 't_barang.id_satuan = t_satuan.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
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
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->cekPerubahan();
    }

    function get($id)
    {
        return $this->db->get_where($this->table, $this->req->id($id))->row();
    }

    function update($data, $where)
    {
        $this->db->where($where);
        $this->db->update('t_barang', $data);
        return $this->cekPerubahan();
    }

    function delete($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table);
        return $this->cekPerubahan();
    }

    function data_barang()
    {
        $this->db->select('*');
        $this->db->from('t_barang');

        $this->db->join('t_satuan', 't_barang.id_satuan = t_satuan.id', 'left');
        $this->db->order_by('t_barang.nama_barang', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
