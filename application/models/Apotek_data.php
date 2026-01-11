<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Apotek_data extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* =======================
       ==== USER / AUTH ======
       ======================= */

    public function simpan_user($data)
    {
        return $this->db->insert('user', $data);
    }

    public function cek_username($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }

    public function get_user_login($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }

    /* =======================
       ==== COUNT FUNCTIONS ===
       ======================= */

    public function insert_data($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    public function count_med() { return $this->db->count_all('table_med'); }
    public function count_cat() { return $this->db->count_all('table_cat'); }
    public function count_sup() { return $this->db->count_all('table_sup'); }
    public function count_unit() { return $this->db->count_all('table_unit'); }
    public function count_inv() { return $this->db->count_all('table_invoice'); }
    public function count_pur() { return $this->db->count_all('table_purchase'); }

    public function count_totinv()
{
    $this->db->select_sum('subtotal');
    $result = $this->db->get('table_invoice')->row();
    return (int) ($result->subtotal ?? 0);
}

public function count_totpur()
{
    $this->db->select_sum('subtotal');
    $result = $this->db->get('table_purchase_detail')->row();
    return (int) ($result->subtotal ?? 0);
}

    public function countstock()
    {
        return $this->db->query("SELECT COUNT(*) AS total FROM table_med_stok WHERE stok <= 0")
                        ->row()->total;
    }

    public function countex()
    {
        return $this->db->query("SELECT COUNT(*) AS total FROM table_med_stok WHERE kedaluwarsa <= CURDATE()")
                        ->row()->total;
    }

    /* =======================
       ==== GET FUNCTIONS =====
       ======================= */

    public function get_category() { return $this->db->get('table_cat')->result(); }
    public function get_unit()     { return $this->db->get('table_unit')->result(); }
    public function get_supplier() { return $this->db->get('table_sup')->result(); }

    public function medicine()
{
    $this->db->select('
        m.id_obat,
        m.nama_obat,
        SUM(s.stok) AS stok,
        MAX(s.harga_jual) AS harga_jual,
        u.unit
    ');
    $this->db->from('table_med m');
    $this->db->join('table_med_stok s', 's.id_obat = m.id_obat', 'left');
    $this->db->join('table_unit u', 'u.id_unit = m.unit', 'left');
    $this->db->group_by('m.id_obat');
    return $this->db->get();
}



    /* =======================
       ==== TABLE QUERIES =====
       ======================= */

    public function category() { return $this->db->get('table_cat'); }
    public function unit()     { return $this->db->get('table_unit'); }
    public function supplier() { return $this->db->get('table_sup'); }

    public function purchase()
{
    return $this->db
        ->select('
            p.id_pembelian,
            p.ref,
            p.tgl_beli,
            p.nama_pemasok,
            d.nama_obat,
            d.harga_beli,
            d.banyak,
            d.subtotal,
            u.unit
        ')
        ->from('table_purchase p')
        ->join('table_purchase_detail d', 'd.id_pembelian = p.id_pembelian')
        ->join('table_med m', 'm.id_obat = d.id_obat', 'left')
        ->join('table_unit u', 'u.id_unit = m.unit', 'left')
        ->order_by('p.tgl_beli', 'DESC')
        ->get()
        ->result();
}


    public function invoice()
{
    $this->db->select('
        i.ref,
        i.tgl_beli,
        m.nama_obat,
        u.unit,
        i.harga_jual,
        i.banyak,
        i.subtotal,
        s.nama_pemasok
    ');
    $this->db->from('table_invoice i');
    $this->db->join('table_med_stok s', 's.id_stok = i.id_stok');
    $this->db->join('table_med m', 'm.id_obat = s.id_obat');
    $this->db->join('table_unit u', 'u.id_unit = m.unit');
    $this->db->order_by('i.id_tagihan', 'DESC');

    return $this->db->get();
}


    /* =======================
       ==== STOCK HANDLER =====
       ======================= */

    public function get_stok_obat($id_obat)
    {
        return $this->db->select('stok')
                        ->get_where('table_med', ['id_obat' => $id_obat])
                        ->row()->stok ?? 0;
    }

    public function tambah_stok($id_obat, $qty)
    {
        $this->db->set('stok', 'stok + '.(int)$qty, false)
                 ->where('id_obat', $id_obat)
                 ->update('table_med');
    }

    public function kurang_stok($id_obat, $qty)
    {
        $this->db->set('stok', 'stok - '.(int)$qty, false)
                 ->where('id_obat', $id_obat)
                 ->update('table_med');
    }

    /* =======================
       ==== TRANSACTION ======
       ======================= */

    public function simpan_penjualan($data)
    {
        $this->db->trans_start();
        $this->db->insert('table_invoice', $data);
        $this->kurang_stok($data['nama_obat'], $data['banyak']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function simpan_pembelian($data)
    {
        $this->db->trans_start();
        $this->db->insert('table_purchase', $data);
        $this->tambah_stok($data['nama_obat'], $data['banyak']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function hapus_penjualan($where)
    {
        $jual = $this->db->get_where('table_invoice', $where)->row();
        if (!$jual) return false;

        $this->db->trans_start();
        $this->db->delete('table_invoice', $where);
        $this->tambah_stok($jual->nama_obat, $jual->banyak);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function hapus_pembelian($where)
    {
        $beli = $this->db->get_where('table_purchase', $where)->row();
        if (!$beli) return false;

        $this->db->trans_start();
        $this->db->delete('table_purchase', $where);
        $this->kurang_stok($beli->nama_obat, $beli->banyak);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /* =======================
       ==== BASIC CRUD =======
       ======================= */

    public function edit_data($where, $table) { return $this->db->get_where($table, $where); }
    public function update_data($where, $data, $table)
    {
        return $this->db->where($where)->update($table, $data);
    }
    public function delete_data($where, $table)
    {
        return $this->db->where($where)->delete($table);
    }

    /* =======================
       ==== AJAX / JSON ======
       ======================= */

    public function getmedbysupplier($nama_pemasok)
    {
        return $this->db->get_where('table_med', ['nama_pemasok' => $nama_pemasok])->result();
    }

    public function outstock()
{
    $this->db->select('
        m.id_obat,
        m.nama_obat,
        k.nama_kategori,
        u.unit,
        COALESCE(SUM(s.stok), 0) AS total_stok
    ');
    $this->db->from('table_med m');
    $this->db->join('table_med_stok s', 'm.id_obat = s.id_obat', 'left');
    $this->db->join('table_cat k', 'k.id_kat = m.nama_kategori', 'left');
    $this->db->join('table_unit u', 'u.id_unit = m.unit', 'left');
    $this->db->group_by('m.id_obat, m.nama_obat, k.nama_kategori, u.unit');
    $this->db->having('total_stok <=', 0);
    return $this->db->get()->result();
}

public function almostout()
{
    $this->db->select('
        m.id_obat,
        m.nama_obat,
        k.nama_kategori,
        u.unit,
        SUM(s.stok) AS total_stok
    ');
    $this->db->from('table_med_stok s');
    $this->db->join('table_med m', 'm.id_obat = s.id_obat', 'left');
    $this->db->join('table_cat k', 'k.id_kat = m.nama_kategori', 'left');
    $this->db->join('table_unit u', 'u.id_unit = m.unit', 'left');
    $this->db->group_by('m.id_obat, m.nama_obat, k.nama_kategori, u.unit');
    $this->db->having('total_stok <=', 5);
    $this->db->having('total_stok >', 0);
    return $this->db->get()->result();
}


   public function expired()
{
    $this->db->select('
        s.*,
        m.nama_obat,
        k.nama_kategori,
        u.unit
    ');
    $this->db->from('table_med_stok s');
    $this->db->join('table_med m', 'm.id_obat = s.id_obat', 'left');
    $this->db->join('table_cat k', 'k.id_kat = m.nama_kategori', 'left');
    $this->db->join('table_unit u', 'u.id_unit = m.unit', 'left');
    $this->db->where('s.kedaluwarsa <=', date('Y-m-d'));
    return $this->db->get()->result();
}

public function almostex()
{
    $this->db->select('
        s.*,
        m.nama_obat,
        k.nama_kategori,
        u.unit
    ');
    $this->db->from('table_med_stok s');
    $this->db->join('table_med m', 'm.id_obat = s.id_obat', 'left');
    $this->db->join('table_cat k', 'k.id_kat = m.nama_kategori', 'left');
    $this->db->join('table_unit u', 'u.id_unit = m.unit', 'left');
    $this->db->where('s.kedaluwarsa >=', date('Y-m-d'));
    $this->db->where('s.kedaluwarsa <=', date('Y-m-d', strtotime('+60 days')));
    return $this->db->get()->result();
}


     public function get_report(){
        $q = "SELECT month.month_name as month, 
            SUM(table_purchase.subtotal) AS total1,
            SUM(table_invoice.subtotal) AS total2  
            FROM month 
            LEFT JOIN table_purchase ON month.month_num = MONTH(table_purchase.tgl_beli)
            AND YEAR(table_purchase.tgl_beli)= '2018'  
            LEFT JOIN table_invoice ON month.month_num = MONTH(table_invoice.tgl_beli)
            AND YEAR(table_invoice.tgl_beli)= '2018' 
            GROUP BY month.month_name ORDER BY month.month_num";
       
        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }

    // Ambil info utama obat
public function get_obat_by_id($id_obat)
{
    return $this->db
        ->select('
            m.id_obat,
            m.nama_obat,
            k.nama_kategori,
            u.unit
        ')
        ->from('table_med m')
        ->join('table_cat k', 'k.id_kat = m.nama_kategori')
        ->join('table_unit u', 'u.id_unit = m.unit')
        ->where('m.id_obat', $id_obat)
        ->get()
        ->row();
}

// Ambil detail stok obat (per pemasok / batch)
public function get_stok_by_obat($id_obat)
{
    return $this->db
        ->select('
            m.nama_obat,
            m.unit,
            s.stok,
            s.harga_beli,
            s.harga_jual,
            s.kedaluwarsa,
            s.nama_pemasok
        ')
        ->from('table_med_stok s')
        ->join('table_med m', 'm.id_obat = s.id_obat')
        ->where('s.id_obat', $id_obat)
        ->where('s.stok >', 0) // Tambahkan filter ini
        ->order_by('s.kedaluwarsa', 'ASC')
        ->get()
        ->result();
}




// Simpan pembelian (header)
public function insert_pembelian($data)
{
    $this->db->insert('table_purchase', $data);
    return $this->db->insert_id();
}

// Simpan stok obat (batch)
public function insert_stok($data)
{
    return $this->db->insert('table_med_stok', $data);
}

// Ambil semua obat (untuk dropdown)
public function get_all_obat()
{
    return $this->db
        ->select('id_obat, nama_obat')
        ->from('table_med')
        ->order_by('nama_obat', 'ASC')
        ->get()
        ->result();
}

// Ambil semua pemasok
public function get_all_pemasok()
{
    return $this->db->get('table_sup')->result();
}
}