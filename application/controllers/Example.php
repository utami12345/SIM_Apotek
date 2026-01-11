<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'functions.php';
/**
* This is Example Controller
*/
class Example extends CI_Controller
{
	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Apotek_data');
        $this->load->database();
        $this->load->helper(array('form', 'url'));
       
        $data['nullstock'] = $this->Apotek_data->countstock();
        $data['nullex'] = $this->Apotek_data->countex();
        $this->template->write_view('sidenavs', 'template/default_sidenavs', true);
		$this->template->write_view('navs', 'template/default_topnavs.php', $data, true);
	}

	public function register()
{
    $this->load->view('tes/register');
}

public function register_user()
{
    $nama     = $this->input->post('nama', true);
    $username = $this->input->post('username', true);
    $password = $this->input->post('password', true);
    $confirm  = $this->input->post('confirm_password', true);
    $level_id = $this->input->post('level_id', true); // pemilik / kasir

    // ===============================
    // VALIDASI KOSONG
    // ===============================
    if (
        empty($nama) ||
        empty($username) ||
        empty($password) ||
        empty($confirm) ||
        empty($level_id)
    ) {
        $this->session->set_flashdata(
            'register_error',
            'Semua field wajib diisi'
        );
        redirect('example/register');
        return;
    }

    // ===============================
    // VALIDASI LEVEL
    // ===============================
    if (!in_array($level_id, ['pemilik', 'kasir'])) {
        $this->session->set_flashdata(
            'register_error',
            'Level tidak valid'
        );
        redirect('example/register');
        return;
    }

    // ===============================
    // VALIDASI PASSWORD
    // minimal 8 karakter
    // huruf + angka + karakter khusus
    // ===============================
    $password_rule = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';

    if (!preg_match($password_rule, $password)) {
        $this->session->set_flashdata(
            'register_error',
            'Password minimal 8 karakter dan harus mengandung huruf, angka, dan karakter khusus'
        );
        redirect('example/register');
        return;
    }

    // ===============================
    // KONFIRMASI PASSWORD
    // ===============================
    if ($password !== $confirm) {
        $this->session->set_flashdata(
            'register_error',
            'Konfirmasi password tidak cocok'
        );
        redirect('example/register');
        return;
    }

    // ===============================
    // CEK USERNAME
    // ===============================
    $cek = $this->db->get_where('user', ['username' => $username])->row();
    if ($cek) {
        $this->session->set_flashdata(
            'register_error',
            'Username sudah digunakan'
        );
        redirect('example/register');
        return;
    }

    // ===============================
    // SIMPAN USER
    // ===============================
    $data = [
        'nama'     => $nama,
        'username' => $username,
        'pass'     => password_hash($password, PASSWORD_DEFAULT),
        'level_id' => $level_id // pemilik / kasir
    ];

    $this->db->insert('user', $data);

    $this->session->set_flashdata(
        'register_success',
        'Registrasi berhasil, silakan login'
    );

    redirect('example/login');
}

public function login()
{
    $this->load->view('tes/login');
}


public function login_masuk()
{
    $username = $this->input->post('username', true);
    $password = $this->input->post('password', true);

    // ===============================
    // AMBIL USER
    // ===============================
    $user = $this->db
        ->get_where('user', ['username' => $username])
        ->row();

    if (!$user) {
        $this->session->set_flashdata(
            'login_error',
            'Username atau password salah'
        );
        redirect('example/login');
        return;
    }

    // ===============================
    // CEK PASSWORD
    // ===============================
    if (!password_verify($password, $user->pass)) {
        $this->session->set_flashdata(
            'login_error',
            'Username atau password salah'
        );
        redirect('example/login');
        return;
    }

    // ===============================
    // SET SESSION
    // ===============================
    $this->session->set_userdata([
        'login'    => true,
        'id_user'  => $user->id,
        'nama'     => $user->nama,
        'username' => $user->username,
        'level'    => $user->level_id // pemilik / kasir
    ]);

    // ===============================
    // REDIRECT SESUAI LEVEL
    // ===============================
    if ($user->level_id === 'pemilik') {
        redirect('example/index'); // dashboard pemilik
    } else {
        redirect('example/index'); // kasir (kalau beda, ganti di sini)
    }
}

public function logout()
	{
		session_destroy();
		session_unset();
		redirect("/example");
	}


	function index() {
		if(!$this->session->userdata("login")) {
			return redirect("example/login");
			exit;
		}
		$data['stockobat'] = $this->Apotek_data->count_med();
		$data['stockkat'] = $this->Apotek_data->count_cat();
		$data['sup'] = $this->Apotek_data->count_sup();
		$data['unit'] = $this->Apotek_data->count_unit();
		$data['inv'] = $this->Apotek_data->count_inv();
		$data['pur'] = $this->Apotek_data->count_pur();
		$data['totpur'] = $this->Apotek_data->count_totpur();
		$data['totinv'] = $this->Apotek_data->count_totinv();

		$this->template->write('title', 'Beranda', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/mypage', $data, true);

		$this->template->render();
	}

	

	function dashboard() {
		$this->template->write('title', 'Dashboard', TRUE);
		$this->template->write('header', 'Dashboard');
		$this->template->write_view('content', 'tes/dashboard', '', true);

		$this->template->render();
	}

	

	function table_exp() {
		$data['table_exp'] = $this->Apotek_data->expired();
		$data['table_alex'] = $this->Apotek_data->almostex();
		$this->template->write('title', 'Obat kedaluwarsa', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_exp', $data, true);

		$this->template->render();

	}

	function table_stock() {
		$data['table_stock'] = $this->Apotek_data->outstock();
		$data['table_alstock'] = $this->Apotek_data->almostout();
		$this->template->write('title', 'Obat Habis', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_stock', $data,  true);

		$this->template->render();
	}

	function form_cat() {
		$this->template->write('title', 'Tambah Kategori', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/form_cat', '', true);

		$this->template->render();
	}

	function form_unit() {
		$this->template->write('title', 'Tambah Unit', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/form_unit', '', true);

		$this->template->render();
	}

	function form_med() {
		$data['get_cat'] = $this->Apotek_data->get_category();
		$data['get_sup'] = $this->Apotek_data->get_supplier();
		$data['get_unit'] = $this->Apotek_data->get_unit();
		$this->template->write('title', 'Tambah Obat', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/form_med', $data, true);

		$this->template->render();
	}

	function table_med()
{
    $data['table_med'] = $this->db
        ->select('
            m.id_obat,
            m.nama_obat,
            k.nama_kategori,
            u.unit,
            COALESCE(SUM(s.stok), 0) AS total_stok
        ')
        ->from('table_med m')
        ->join('table_cat k', 'k.id_kat = m.nama_kategori')
        ->join('table_unit u', 'u.id_unit = m.unit')
        ->join('table_med_stok s', 's.id_obat = m.id_obat', 'left')
        ->group_by('m.id_obat')
        ->get()
        ->result();

    $this->template->write('title', 'Daftar Obat', TRUE);
    $this->template->write('header', 'Sistem Informasi Apotek');
    $this->template->write_view('content', 'tes/table_med', $data, true);
    $this->template->render();
}

public function detail_obat($id_obat)
{
    $this->load->model('Apotek_data');

    $data['obat'] = $this->Apotek_data->get_obat_by_id($id_obat);
    $data['stok'] = $this->Apotek_data->get_stok_by_obat($id_obat);

    if (!$data['obat']) {
        show_404();
    }

    $this->template->write('title', 'Detail Obat', TRUE);
    $this->template->write('header', 'Sistem Informasi Apotek');
    $this->template->write_view('content', 'tes/detail_obat', $data, true);
    $this->template->render();
}

public function get_detail_obat($id_obat)
{
    return $this->db
        ->select('
            p.ref,
            p.tgl_beli,
            d.banyak,
            d.harga_beli,
            d.subtotal,
            p.nama_pemasok
        ')
        ->from('table_purchase_detail d')
        ->join('table_purchase p', 'p.id_pembelian = d.id_pembelian')
        ->where('d.id_obat', $id_obat)
        ->order_by('p.tgl_beli', 'DESC')
        ->get()
        ->result();
}




	function table_unit() {
		
		$data['table_unit'] = $this->Apotek_data->unit()->result();
		$this->template->write('title', 'Lihat Unit', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_unit', $data, true);

		$this->template->render();
		
	}


	function invoice_report() {		
		$this->template->write('title', 'Grafik Penjualan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/invoice_report', true);

		$this->template->render();
		
	}

	function purchase_report() {

		$this->template->write('title', 'Grafik Pembelian', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/purchase_report', true);

		$this->template->render();
		
	}

	function report() {
		$data['totpur'] = $this->Apotek_data->count_totpur();
		$data['totinv'] = $this->Apotek_data->count_totinv();
		$data['report'] = $this->Apotek_data->get_report();
		$this->template->write('title', 'Laporan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/report', $data, true);

		$this->template->render();
		
	}

	function table_cat() {
		
		$data['table_cat'] = $this->Apotek_data->category()->result();
		$this->template->write('title', 'Lihat Kategori', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_cat', $data, true);

		$this->template->render();
	}

	function table_sup() {
		$data['table_sup'] = $this->Apotek_data->supplier()->result();
		
		$this->template->write('title', 'Lihat Pemasok', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_sup', $data, true);

		$this->template->render();
	}

	function stok_penjualan() {
		$data['table_sup'] = $this->Apotek_data->supplier()->result();
		$data['result']	=	$this->db->query("SELECT * FROM stok WHERE status_id = 'penjualan'")->result_object();
		
		$this->template->write('title', 'Laporan Stok Penjualan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/stok_penjualan', $data, true);

		$this->template->render();
	}

	function stok_pembelian() {
		$data['table_sup'] = $this->Apotek_data->supplier()->result();
		$data['result']	=	$this->db->query("SELECT * FROM stok WHERE status_id = 'pembelian'")->result_object();
		
		$this->template->write('title', 'Laporan Stok Pembelian', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/stok_pembelian', $data, true);

		$this->template->render();
	}

	

	function form_sup() {
		$this->template->write('title', 'Tambah Pemasok', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/form_sup', '', true);

		$this->template->render();
	}


	// ================= FORM INVOICE =================
public function form_invoice()
    {
        // Ambil semua stok yang masih ada, urut berdasarkan tanggal kadaluarsa (FEFO)
        $data['obat'] = $this->db
            ->select('
                s.id_stok,
                m.id_obat,
                m.nama_obat,
                s.stok,
                s.harga_jual,
                s.kedaluwarsa,
                u.unit
            ')
            ->from('table_med_stok s')
            ->join('table_med m', 'm.id_obat = s.id_obat')
            ->join('table_unit u', 'u.id_unit = m.unit')
            ->where('s.stok >', 0)
            ->order_by('s.kedaluwarsa', 'ASC') // FEFO: yang kadaluarsa duluan tampil paling atas
            ->get()
            ->result();

        // Tulis template
        $this->template->write('title', 'Tambah Penjualan', TRUE);
        $this->template->write('header', 'Sistem Informasi Apotek');
        $this->template->write_view('content', 'tes/form_invoice', $data);
        $this->template->render();
    }


public function form_purchase()
{
    $this->load->model('Apotek_data');

    $data['obat'] = $this->Apotek_data->get_all_obat();
    $data['pemasok'] = $this->Apotek_data->get_all_pemasok();

    $this->template->write('title', 'Tambah Pembelian', TRUE);
    $this->template->write_view('content', 'tes/form_purchase', $data, true);
    $this->template->render();
}


public function save_purchase()
{
    $this->db->trans_start();

    $ref = 'PB' . date('YmdHis') . rand(100,999);

    $id_obat       = $this->input->post('id_obat');
    $nama_pemasok  = $this->input->post('nama_pemasok');
    $qty           = $this->input->post('qty');
    $harga_beli    = $this->input->post('harga_beli');
    $harga_jual    = $this->input->post('harga_jual');
    $kedaluwarsa   = $this->input->post('kedaluwarsa');

    if (!$id_obat || !$qty) {
        $this->db->trans_rollback();
        show_error('Data pembelian tidak lengkap');
    }

    $obat = $this->db
        ->get_where('table_med', ['id_obat' => $id_obat])
        ->row();

    if (!$obat) {
        $this->db->trans_rollback();
        show_error('Obat tidak ditemukan');
    }

    $subtotal = $qty * $harga_beli;

    // HEADER
    $this->db->insert('table_purchase', [
        'ref'          => $ref,
        'tgl_beli'     => date('Y-m-d'),
        'nama_pemasok' => $nama_pemasok,
        'grandtotal'   => $subtotal,
        'created_at'   => date('Y-m-d H:i:s')
    ]);

	// AMBIL ID PEMBELIAN
    $id_pembelian = $this->db->insert_id();

    // DETAIL
    $this->db->insert('table_purchase_detail', [
        'id_pembelian' => $id_pembelian,
		'id_obat'    => $id_obat,
        'nama_obat'  => $obat->nama_obat,
        'banyak'     => $qty,
        'harga_beli' => $harga_beli,
        'subtotal'   => $subtotal
    ]);

    // STOK
    $this->db->insert('table_med_stok', [
		'id_pembelian' => $id_pembelian,
        'id_obat'      => $id_obat,
        'stok'         => $qty,
        'harga_beli'   => $harga_beli,
        'harga_jual'   => $harga_jual,
        'kedaluwarsa'  => $kedaluwarsa,
        'nama_pemasok' => $nama_pemasok
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        show_error('Gagal menyimpan pembelian');
    }

    $this->session->set_flashdata('pur_added', 'Pembelian berhasil disimpan');
    redirect('example/table_purchase');
}


	function table_purchase() {
		$data['table_purchase'] = $this->Apotek_data->purchase();
		
		$this->template->write('title', 'Lihat Pembelian', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_purchase', $data, true);

		$this->template->render();
	}

	



	function cari_laba_rugi() {
		$kategori = $this->input->post("kategori");
		if($kategori == "semua") {
			$main = $this->db->query("SELECT * FROM stok WHERE  kategori = '$kategori'")->num_rows();
			$main_satu = $this->db->query("SELECT * FROM stok WHERE  kategori = '$kategori'")->result_object();
		} else {
			$main = $this->db->query("SELECT * FROM stok WHERE  kategori = '$kategori'")->num_rows();
			$main_satu = $this->db->query("SELECT * FROM stok WHERE  kategori = '$kategori'")->result_object();
		}
		if($main) {
			$data['result'] = $main_satu;
			$data['cari'] = true;
			
			$this->template->write('title', 'Laporan Laba Rugi', TRUE);
			$this->template->write('header', 'Sistem Informasi Apotek');
			$this->template->write_view('content', 'tes/laba_rugi', $data, true);
	
			$this->template->render();
		} else {
			echo "<script>
				alert('Data Tidak Ditemukan');
				document.location.href = '../example/laba_rugi';
			</script>";
			exit;
		}
	}

	function cari_stok_penjualan() {
		$kategori = $this->input->post("kategori");
		$waktu = $this->input->post("waktu");
		if($kategori == "semua") {
			$main = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND status_id = 'penjualan'")->num_rows();
			$main_satu = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND status_id = 'penjualan'")->result_object();
		} else {
			$main = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND kategori = '$kategori' AND status_id = 'penjualan'")->num_rows();
			$main_satu = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND kategori = '$kategori' AND status_id = 'penjualan'")->result_object();
		}
		if($main) {
			$data['result'] = $main_satu;
			$data['cari'] = true;
			$data['start'] =	$waktu;
			
			$this->template->write('title', 'Laporan Stok Penjualan', TRUE);
			$this->template->write('header', 'Sistem Informasi Apotek');
			$this->template->write_view('content', 'tes/stok_penjualan', $data, true);
	
			$this->template->render();
		} else {
			echo "<script>
				alert('Data Tidak Ditemukan');
				document.location.href = '../example/stok_penjualan';
			</script>";
			exit;
		}
	}

	
	function cari_stok_pembelian() {
		$kategori = $this->input->post("kategori");
		$waktu = $this->input->post("waktu");
		if($kategori == "semua") {
			$main = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND status_id = 'pembelian'")->num_rows();
			$main_satu = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu'  AND status_id = 'pembelian'")->result_object();
		} else {
			$main = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND kategori = '$kategori'  AND status_id = 'pembelian'")->num_rows();
			$main_satu = $this->db->query("SELECT * FROM stok  WHERE  tanggal = '$waktu' AND kategori = '$kategori'  AND status_id = 'pembelian'")->result_object();
		}
		if($main) {
			$data['result'] = $main_satu;
			$data['cari'] = true;
			$data['start'] =	$waktu;
			
			$this->template->write('title', 'Laporan Stok Pembelian', TRUE);
			$this->template->write('header', 'Sistem Informasi Apotek');
			$this->template->write_view('content', 'tes/stok_pembelian', $data, true);
	
			$this->template->render();
		} else {
			echo "<script>
				alert('Data Tidak Ditemukan');
				document.location.href = '../example/stok_pembelian';
			</script>";
			exit;
		}
	}
	
	public function cari_penjualan()
{
    $kategori = $this->input->post('kategori');
    $waktu    = $this->input->post('waktu');

    $this->db->select('
        i.id_tagihan,
        i.ref,
        i.tgl_beli,
        i.nama_pembeli,
        m.nama_obat,
        u.unit,
        i.harga_jual,
        i.banyak,
        i.subtotal,
    ');
    $this->db->from('table_invoice i');

    $this->db->join('table_med m', 'm.id_obat = i.nama_obat', 'left');
    $this->db->join('table_unit u', 'u.id_unit = m.unit', 'left');
    $this->db->where('DATE(i.tgl_beli)', $waktu);
    $this->db->order_by('i.id_tagihan', 'DESC');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {

        $data['table_invoice'] = $query->result();
        $data['cari']  = true;
        $data['start'] = $waktu;

        $this->template->write('title', 'Lihat Penjualan', TRUE);
        $this->template->write('header', 'Sistem Informasi Apotek');
        $this->template->write_view('content', 'tes/table_invoice', $data, true);
        $this->template->render();

    } else {
        echo "<script>
            alert('Data Tidak Ditemukan');
            window.location.href = '".base_url('example/table_invoice')."';
        </script>";
        exit;
    }
}


	function getmedbysupplier(){
        $nama_pemasok=$this->input->post('nama_pemasok');
        $data=$this->apotek_data->getmedbysupplier($nama_pemasok);
        echo json_encode($data);
    }


	

	function form_customer() {
		$this->template->write('title', 'Tambah Pelanggan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/form_customer', '', true);

		$this->template->render();
	}

	function laba_rugi() {
		$data =[
			'result'	=>	$this->db->query("SELECT * FROM stok")->result_object()
		];
		$this->template->write('title', 'Tambah Pelanggan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/laba_rugi', $data, true);

		$this->template->render();
	}

	function laporan_pembelian_tanggal() {
		$data = [
			'result'	=> $this->db->query("SELECT * FROM table_purchase ")->result_object()
		];
		$this->template->write('title', 'Laporan Pembelian Pertanggal', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/laporan_pembelian_tanggal', $data, true);

		$this->template->render();
	}
	function laporan_penjualan_tanggal() {
		$data = [
			'result'	=> $this->db->query("SELECT * FROM table_invoice ")->result_object()
		];
		$this->template->write('title', 'Laporan Pembelian Pertanggal', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/laporan_penjualan_tanggal', $data, true);

		$this->template->render();
	}

	function cari_laporan_beli() {
		$kategori = $this->input->post("kategori");
		$mulai = $this->input->post("mulai");
		$akhir = $this->input->post("akhir");

		if($kategori == "semua") {
			$result = $this->db->query("SELECT * FROM table_purchase WHERE tgl_beli BETWEEN '$mulai' AND '$akhir'")->num_rows();
			$result_satu = $this->db->query("SELECT * FROM table_purchase WHERE tgl_beli BETWEEN '$mulai' AND '$akhir'")->result_object();
		} else {
			$result = $this->db->query("SELECT * FROM table_purchase LEFT JOIN table_med ON table_med.nama_obat = table_purchase.nama_obat 
			 LEFT JOIN table_cat ON table_cat.nama_kategori = table_med.nama_kategori WHERE table_med.nama_kategori = '$kategori' AND  tgl_beli BETWEEN '$mulai' AND '$akhir'")->num_rows();
			 $result_satu =  $this->db->query("SELECT * FROM table_purchase LEFT JOIN table_med ON table_med.nama_obat = table_purchase.nama_obat 
			 LEFT JOIN table_cat ON table_cat.nama_kategori = table_med.nama_kategori WHERE table_med.nama_kategori = '$kategori' AND  tgl_beli BETWEEN '$mulai' AND '$akhir'")->result_object();
		}
		if($result) {
			$data = [
				'result'	=>	$result_satu,
				'cari'	=>	true,
				'start' =>	$mulai,
				"end"	=>	$akhir
			];
			$this->template->write('title', 'Laporan Pembelian Pertanggal', TRUE);
			$this->template->write('header', 'Sistem Informasi Apotek');
			$this->template->write_view('content', 'tes/laporan_pembelian_tanggal', $data, true);
	
			$this->template->render();
		} else {
			echo "<script>
			alert('Data Tidak Ditemukan');
			document.location.href = '../example/laporan_pembelian_tanggal';
			</script>";
			exit;
		}

	}

	function cari_laporan_jual() {
		$kategori = $this->input->post("kategori");
		$mulai = $this->input->post("mulai");
		$akhir = $this->input->post("akhir");

		if($kategori == "semua") {
			$result = $this->db->query("SELECT * FROM table_invoice WHERE tgl_beli BETWEEN '$mulai' AND '$akhir'")->num_rows();
			$result_satu = $this->db->query("SELECT * FROM table_invoice WHERE tgl_beli BETWEEN '$mulai' AND '$akhir'")->result_object();
		} else {
			$result = $this->db->query("SELECT * FROM table_invoice LEFT JOIN table_med ON table_med.nama_obat = table_invoice.nama_obat 
			 LEFT JOIN table_cat ON table_cat.nama_kategori = table_med.nama_kategori WHERE table_med.nama_kategori = '$kategori' AND  tgl_beli BETWEEN '$mulai' AND '$akhir'")->num_rows();
			 $result_satu =  $this->db->query("SELECT * FROM table_invoice LEFT JOIN table_med ON table_med.nama_obat = table_invoice.nama_obat 
			 LEFT JOIN table_cat ON table_cat.nama_kategori = table_med.nama_kategori WHERE table_med.nama_kategori = '$kategori' AND  tgl_beli BETWEEN '$mulai' AND '$akhir'")->result_object();
		}
		if($result) {
			$data = [
				'result'	=>	$result_satu,
				'cari'	=>	true,
				'start' =>	$mulai,
				"end"	=>	$akhir
			];
			$this->template->write('title', 'Laporan Pembelian Pertanggal', TRUE);
			$this->template->write('header', 'Sistem Informasi Apotek');
			$this->template->write_view('content', 'tes/laporan_penjualan_tanggal', $data, true);
	
			$this->template->render();
		} else {
			echo "<script>
			alert('Data Tidak Ditemukan');
			document.location.href = '../example/laporan_penjualan_tanggal';
			</script>";
			exit;
		}

	}

	

	function table_customer() {
		$this->template->write('title', 'Lihat Pelanggan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_customer', '', true);

		$this->template->render();
	}

	function table_invoice() {
		$data['table_invoice'] = $this->Apotek_data->invoice()->result();
		$this->template->write('title', 'Lihat Penjualan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/table_invoice', $data, true);

		$this->template->render();
	}



	function add_medicine()
	{
		$nama_obat = $this->input->post('nama_obat');
		$unit = $this->input->post('unit');
		$nama_kategori = $this->input->post('nama_kategori');
	
		$data = array(
			'nama_obat' => $nama_obat,
			'unit' => $unit,
			'nama_kategori' => $nama_kategori,
			);
		$this->Apotek_data->insert_data($data,'table_med');

		$this->session->set_flashdata('med_added', 'Obat berhasil ditambahkan');
		redirect('example/table_med');

	}


	function add_category(){
		$nama_kategori = $this->input->post('nama_kategori');
		$des_kat = $this->input->post('des_kat');
 
		$data = array(
			'nama_kategori' => $nama_kategori,
			'des_kat' => $des_kat,
			
			);
		$this->Apotek_data->insert_data($data,'table_cat');

		$this->session->set_flashdata('cat_added', 'Kategori berhasil ditambahkan');
		redirect('example/table_cat');
	}

	function add_unit(){
		$unit = $this->input->post('unit');
		$data = array(
			'unit' => $unit,
			
			
			);
		$this->Apotek_data->insert_data($data,'table_unit');

		$this->session->set_flashdata('unit_added', 'Unit berhasil ditambahkan');
		redirect('example/table_unit');
	}


	function add_supplier(){
		$nama_pemasok = $this->input->post('nama_pemasok');
		$alamat = $this->input->post('alamat');
		$telepon = $this->input->post('telepon');
 
		$data = array(
			'nama_pemasok' => $nama_pemasok,
			'alamat' => $alamat,
			'telepon' => $telepon,
			);
		$this->Apotek_data->insert_data($data,'table_sup');

		$this->session->set_flashdata('sup_added', 'Pemasok berhasil ditambahkan');
		redirect('example/table_sup');
	}


	public function add_invoice()
    {
        $id_stok = $this->input->post('id_stok');
        $banyak  = $this->input->post('banyak');

        if (!is_array($id_stok) || count($id_stok) == 0) {
            show_error('Data stok tidak valid');
        }

        $ref = uniqid('INV'); // Reference invoice unik

        foreach ($id_stok as $i => $stok_id) {

            // Ambil stok batch
            $stok = $this->db->get_where('table_med_stok', [
                'id_stok' => $stok_id
            ])->row();

            if (!$stok) continue;

            // VALIDASI: tidak boleh jual melebihi stok
            if ($banyak[$i] > $stok->stok) {
                show_error('Jumlah melebihi stok tersedia untuk '.$stok->nama_obat);
            }

            // SIMPAN KE INVOICE
            $this->db->insert('table_invoice', [
                'ref'         => $ref,
                'tgl_beli'    => $this->input->post('tgl_beli'),
                'nama_pembeli'=> $this->input->post('nama_pembeli'),
                'id_stok'     => $stok->id_stok,
                'harga_jual'  => $stok->harga_jual,
                'banyak'      => $banyak[$i],
                'subtotal'    => $stok->harga_jual * $banyak[$i]
            ]);

            // KURANGI STOK
            $this->db->set('stok', 'stok - '.$banyak[$i], FALSE);
            $this->db->where('id_stok', $stok->id_stok);
            $this->db->update('table_med_stok');
        }

        // Redirect ke tabel invoice
        redirect('example/table_invoice');
    }

	public function add_purchase()
{
    $ref        = generateRandomString();
    $tgl_beli   = $this->input->post('tgl_beli');
    $id_pemasok = $this->input->post('id_pemasok');

    $nama_obat  = $this->input->post('nama_obat');
    $harga      = $this->input->post('harga_beli');
    $banyak     = $this->input->post('banyak');

    // ===== VALIDASI =====
    if (!$id_pemasok) {
        $this->session->set_flashdata('error', 'Pemasok wajib dipilih');
        redirect('example/form_purchase');
    }

    if (!is_array($nama_obat)) {
        $this->session->set_flashdata('error', 'Obat belum dipilih');
        redirect('example/form_purchase');
    }

    // ===== SIMPAN =====
    for ($i = 0; $i < count($nama_obat); $i++) {

        $sub = (int)$harga[$i] * (int)$banyak[$i];

        $this->db->insert('table_purchase', [
            'ref'           => $ref,
            'tgl_beli'      => $tgl_beli,
            'nama_pemasok'  => $id_pemasok, // sesuai DB kamu
            'nama_obat'     => $nama_obat[$i],
            'harga_beli'    => $harga[$i],
            'banyak'        => $banyak[$i],
            'subtotal'      => $sub,
        ]);

        // update stok
        $this->db->set('stok', 'stok+' . (int)$banyak[$i], false);
        $this->db->where('nama_obat', $nama_obat[$i]);
        $this->db->update('table_med');
    }

    $this->session->set_flashdata('pur_added', 'Pembelian berhasil disimpan');
    redirect('example/table_purchase');
}

	function invoice_page($ref) {
		$where = array('ref' => $ref);
		$data['table_invoice'] = $this->Apotek_data->show_data($where, 'table_invoice')->result();
		$data['show_invoice'] = $this->Apotek_data->show_invoice($where, 'table_invoice')->result();
		$this->template->write('title', 'Invoice Penjualan', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/invoice', $data, true);

		$this->template->render();
	}


	function purchase_page($ref) {
		$where = array('ref' => $ref);
		$data['table_purchase'] = $this->Apotek_data->show_data($where, 'table_purchase')->result();
		$data['show_invoice'] = $this->Apotek_data->show_invoice($where, 'table_purchase')->result();
		$this->template->write('title', 'Invoice Pembelian', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/purchase', $data, true);

		$this->template->render();
	}


	function edit_form_cat($id_kat) {
		$where = array('id_kat' => $id_kat);
		$data['table_cat'] = $this->Apotek_data->edit_data($where,'table_cat')->result();
		$this->template->write('title', 'Ubah Kategori', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/edit_form_cat', $data, true);

		$this->template->render();
	}

	function update_category(){
		$id_kat = $this->input->post('id_kat');
		$nama_kategori = $this->input->post('nama_kategori');
		$des_kat = $this->input->post('des_kat');

		$data = array(
			'nama_kategori' => $nama_kategori,
			'des_kat' => $des_kat,
		);

		$where = array(
			'id_kat' => $id_kat
		);

		$this->Apotek_data->update_data($where,$data,'table_cat');

		$this->session->set_flashdata('cat_added', 'Data kategori berhasil diperbarui');
		redirect('example/table_cat');
	}

	function edit_form_med($id_obat) {
		$data['get_cat'] = $this->Apotek_data->get_category();
		$data['get_sup'] = $this->Apotek_data->get_supplier();
		$data['get_unit'] = $this->Apotek_data->get_unit();
		$where = array('id_obat' => $id_obat);
		$data['table_med'] = $this->Apotek_data->edit_data($where,'table_med')->result();
		$this->template->write('title', 'Ubah Obat', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/edit_form_med', $data, true);

		$this->template->render();
	}

	function update_medicine(){
		$id_obat = $this->input->post('id_obat');
		$nama_obat = $this->input->post('nama_obat');
		$penyimpanan = $this->input->post('penyimpanan');
		$stok = $this->input->post('stok');
		$unit = $this->input->post('unit');
		$nama_kategori = $this->input->post('nama_kategori');
		$kedaluwarsa = date("Y-m-d",strtotime($this->input->post('kedaluwarsa')));
		$des_obat = $this->input->post('des_obat');
		$harga_beli = $this->input->post('harga_beli');
		$harga_jual = $this->input->post('harga_jual');
		$nama_pemasok = $this->input->post('nama_pemasok');
	
		$data = array(
			'nama_obat' => $nama_obat,
			'penyimpanan' => $penyimpanan,
			'stok' => $stok,
			'unit' => $unit,
			'nama_kategori' => $nama_kategori,
			'kedaluwarsa' => $kedaluwarsa,
			'des_obat' => $des_obat,
			'harga_beli' => $harga_beli,
			'harga_jual' => $harga_jual,
			'nama_pemasok' => $nama_pemasok,
		);

		$where = array(
			'id_obat' => $id_obat
		);

		$this->Apotek_data->update_data($where,$data,'table_med');
		$this->session->set_flashdata('med_added', 'Data obat berhasil diperbarui');
		redirect('example/table_med');
	}


	function edit_form_sup($id_pem) {
		$where = array('id_pem' => $id_pem);
		$data['table_sup'] = $this->Apotek_data->edit_data($where,'table_sup')->result();
		$this->template->write('title', 'Ubah Pemasok', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/edit_form_sup', $data, true);

		$this->template->render();
	}

	function edit_form_unit($id_unit) {
		$where = array('id_unit' => $id_unit);
		$data['table_unit'] = $this->Apotek_data->edit_data($where,'table_unit')->result();
		$this->template->write('title', 'Ubah Unit', TRUE);
		$this->template->write('header', 'Sistem Informasi Apotek');
		$this->template->write_view('content', 'tes/edit_form_unit', $data, true);

		$this->template->render();
	}


	function update_supplier(){
		$id_pem = $this->input->post('id_pem');
		$nama_pemasok = $this->input->post('nama_pemasok');
		$alamat = $this->input->post('alamat');
		$telepon = $this->input->post('telepon');

		$data = array(
			'nama_pemasok' => $nama_pemasok,
			'alamat' => $alamat,
			'telepon' => $telepon,
		);

		$where = array(
			'id_pem' => $id_pem
		);

		$this->Apotek_data->update_data($where,$data,'table_sup');

		$this->session->set_flashdata('sup_added', 'Data pemasok berhasil diperbarui');
		redirect('example/table_sup');
	}

	function update_unit(){
		$id_unit = $this->input->post('id_unit');
		$unit = $this->input->post('unit');
		
		$data = array(
			'unit' => $unit,
		
		);

		$where = array(
			'id_unit' => $id_unit
		);

		$this->Apotek_data->update_data($where,$data,'table_unit');

		$this->session->set_flashdata('unit_added', 'Data unit berhasil diperbarui');
		redirect('example/table_unit');
	}


	function remove_med($id_obat){
		$where = array('id_obat' => $id_obat);
		$this->Apotek_data->delete_data($where,'table_med');
		redirect('example/table_med');
	}

	function remove_cat($id_kat){
		$rt = $this->db->query("SELECT * FROM table_cat WHERE id_kat = '$id_kat'")->row_array();
		$kategori = $rt['nama_kategori'];
		$result = $this->db->query("SELECT * FROM table_med WHERE nama_kategori = '$kategori'")->row_array();
		if($result) {
			echo "<script>
			alert('Data Tidak Boleh Di Hapus');
			document.location.href = '../../example/table_cat';
			</script>";
		}
		$where = array('id_kat' => $id_kat);
		$this->Apotek_data->delete_data($where,'table_cat');
		redirect('example/table_cat');
	}

	function remove_sup($id_pem){
		$where = array('id_pem' => $id_pem);
		$this->Apotek_data->delete_data($where,'table_sup');
		redirect('example/table_sup');
	}

	function remove_unit($id_unit){
		$rt = $this->db->query("SELECT * FROM table_unit WHERE id_unit = '$id_unit'")->row_array();
		$unit = $rt['unit'];
		$result = $this->db->query("SELECT * FROM table_med WHERE unit = '$unit'")->row_array();
		if($result) {
			echo "<script>
			alert('Data Tidak Boleh Di Hapus');
			document.location.href = '../../example/table_unit';
			</script>";
			exit;
		}
		$where = array('id_unit' => $id_unit);
		
		$this->Apotek_data->delete_data($where,'table_unit');
		redirect('example/table_unit');
	}


	public function remove_inv($ref)
{
    // Mulai transaction
    $this->db->trans_start();

    // Ambil semua item penjualan berdasarkan ref
    $invoice_items = $this->db->get_where('table_invoice', ['ref' => $ref])->result();

    if ($invoice_items) {
        foreach ($invoice_items as $item) {

            // Cek apakah batch stok masih ada
            $stok_batch = $this->db->get_where('table_med_stok', ['id_stok' => $item->id_stok])->row();

            if ($stok_batch) {
                // Jika batch masih ada, kembalikan stok
                $this->db->set('stok', 'stok + '.$item->banyak, FALSE);
                $this->db->where('id_stok', $item->id_stok);
                $this->db->update('table_med_stok');
            } else {
                // Jika batch sudah dihapus karena habis, buat baris baru
                $this->db->insert('table_med_stok', [
                    'id_stok'     => $item->id_stok,
                    'id_obat'     => $item->id_obat,
                    'stok'        => $item->banyak,
                    'harga_beli'  => $item->harga_beli,
                    'harga_jual'  => $item->harga_jual,
                    'kedaluwarsa' => $item->kedaluwarsa,
                    'nama_pemasok'=> $item->nama_pemasok
                ]);
            }

        }

        // Hapus data penjualan
        $this->db->where('ref', $ref);
        $this->db->delete('table_invoice');
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('inv_deleted', 'Gagal membatalkan penjualan. Stok tetap.');
    } else {
        $this->session->set_flashdata('inv_deleted', 'Penjualan berhasil dibatalkan dan stok dikembalikan.');
    }

    redirect('example/table_invoice');
}


	public function remove_purchase($id_pembelian)
{
    $this->db->trans_start();

    // hapus stok
    $this->db->delete('table_med_stok', [
        'id_pembelian' => $id_pembelian
    ]);

    // hapus detail pembelian
    $this->db->delete('table_purchase_detail', [
        'id_pembelian' => $id_pembelian
    ]);

    // hapus header
    $this->db->delete('table_purchase', [
        'id_pembelian' => $id_pembelian
    ]);

    $this->db->trans_complete();

    redirect('example/table_purchase');
}



	 function product()
	{
	    $nama_obat=$this->input->post('nama_obat');
        $data=$this->Apotek_data->get_product($nama_obat);
        echo json_encode($data);
	}

	 


	function chart()
	{
       $data = $this->Apotek_data->get_chart_cat();
		echo json_encode($data);
	}

	function chart_unit()
	{
       $data = $this->Apotek_data->get_chart_unit();
		echo json_encode($data);
	}


	function chart_trans()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->get_chart_trans($tahun_beli);
		echo json_encode($data);
	}

	function chart_purchase()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->get_chart_purchase($tahun_beli);
		echo json_encode($data);
	}

	function gabung()
	{
       $tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->get_gabung($tahun_beli);
		echo json_encode($data);
	}

	function topdemand()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->topDemanded($tahun_beli);
		echo json_encode($data);
	}

	function leastdemand()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->leastDemanded($tahun_beli);
		echo json_encode($data);
	}

	function highearn()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->highestEarners($tahun_beli);
		echo json_encode($data);
	}

	function lowearn()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->lowestEarners($tahun_beli);
		echo json_encode($data);
	}

	function toppurchase()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->topPurchase($tahun_beli);
		echo json_encode($data);
	}

	function leastpurchase()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->leastPurchase($tahun_beli);
		echo json_encode($data);
	}

	function highpurchase()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->highestPurchase($tahun_beli);
		echo json_encode($data);
	}

	function lowpurchase()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->lowestPurchase($tahun_beli);
		echo json_encode($data);
	}



	function totale()
	{
		$tahun_beli=$this->input->post('tahun_beli');
       	$data = $this->Apotek_data->get_tot($tahun_beli);
		echo json_encode($data);
	}


	// ===============================
// ====== FUNGSI STOK AUTO =======
// ===============================

/**
 * Kurangi stok (penjualan)
 */
public function kurangi_stok($id_obat, $qty)
{
    $this->db->set('stok', 'stok-' . (int)$qty, false);
    $this->db->where('id_obat', $id_obat);
    $this->db->update('table_med');
}

/**
 * Tambah stok (pembelian)
 */
public function tambah_stok($id_obat, $qty)
{
    $this->db->set('stok', 'stok+' . (int)$qty, false);
    $this->db->where('id_obat', $id_obat);
    $this->db->update('table_med');
}

/**
 * Simpan penjualan + update stok
 */
public function simpan_penjualan($data_invoice, $stok_log)
{
    $this->db->trans_start();

    // insert invoice
    $this->db->insert('table_invoice', $data_invoice);

    // update stok
    $this->kurangi_stok($data_invoice['nama_obat'], $data_invoice['banyak']);

    // log stok
    $this->db->insert('stok', $stok_log);

    $this->db->trans_complete();
}

/**
 * Simpan pembelian + update stok
 */
public function simpan_pembelian($data_purchase, $stok_log)
{
    $this->db->trans_start();

    // insert purchase
    $this->db->insert('table_purchase', $data_purchase);

    // update stok
    $this->tambah_stok($data_purchase['nama_obat'], $data_purchase['banyak']);

    // log stok
    $this->db->insert('stok', $stok_log);

    $this->db->trans_complete();
}
}




