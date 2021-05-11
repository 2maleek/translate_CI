<?php 

class Surat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Surat_model');
        $this->load->library('session');
	}
	
	public function index(){
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("Login");
		}
		else {
			$this->surat_masuk();
		}
	}

    public function surat_masuk(){

        if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("Login");
		}
	
			
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3); //del
		$idu					= $this->uri->segment(4); //1444
		
		

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));

		$usulan_masuk			= addslashes($this->input->post('usulan_masuk'));
		$surat_balasan			= addslashes($this->input->post('surat_balasan'));
		$unit_pelayanan			= addslashes($this->input->post('unit_pelayanan'));
		$disposisi				= addslashes($this->input->post('disposisi'));
		$uraian_usulan			= addslashes($this->input->post('uraian_usulan'));
		$kesimpulan_analisa		= addslashes($this->input->post('kesimpulan_analisa'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$status					= addslashes($this->input->post('status'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_masuk';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_masuk WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('surat/surat_masuk');


		} else if ($mau_ke == "add") {
			$q_nomer_terakhir = $this->db->query("SELECT (MAX(usulan_masuk)) AS last FROM t_surat_masuk WHERE id ='$idu'")->row_array();
			$a['page']		= "e_surat_masuk";

		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE id = '$idu'")->row();	
			$a['page']		= "e_surat_masuk";
			
		} else if ($mau_ke == "edl") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE id = '$idu'")->row();	
			$a['page']		= "l_surat_masuk";


		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_masuk VALUES (NULL, '$usulan_masuk','$surat_balasan', '$unit_pelayanan', '$disposisi', '$uraian_usulan', '$kesimpulan_analisa', NOW(), '$keterangan', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."' , '$status' )");

			} else {
				$this->db->query("INSERT INTO t_surat_masuk VALUES (NULL, '$usulan_masuk','$surat_balasan', '$unit_pelayanan', '$disposisi', '$uraian_usulan', '$kesimpulan_analisa', NOW(), '$keterangan', '', '".$this->session->userdata('admin_id')."' , '$status' )");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('surat/surat_masuk');

		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_surat_masuk SET usulan_masuk = '$usulan_masuk', surat_balasan = '$surat_balasan', unit_pelayanan = '$unit_pelayanan', disposisi = '$disposisi', uraian_usulan = '$uraian_usulan', kesimpulan_analisa = '$kesimpulan_analisa', keterangan = '$keterangan', file = '".$up_data['file_name']."', status = '$status' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_masuk SET usulan_masuk = '$usulan_masuk', surat_balasan = '$surat_balasan', unit_pelayanan = '$unit_pelayanan', disposisi = '$disposisi', uraian_usulan = '$uraian_usulan', kesimpulan_analisa = '$kesimpulan_analisa', keterangan = '$keterangan', status = '$status' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('surat/surat_masuk');

		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_masuk ORDER BY id DESC ")->result();
			$a['page']		= "t_surat_masuk";
		}
		
		$this->load->view('header', $a);
	}
	public function cetak_surat_masuk(){

		$temp = $this->input->post('cetak');
	
		if ($temp == ''){
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">Surat harus dipilih!</div>");
			redirect('surat');
		}
		else{

			if (count($temp) == 1) {
				$id_surat = (string)$temp[0];
			} 
			else {
				$id_surat = (string)implode(',', $temp);
			}
			$a['data']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE id in ( $id_surat ) ORDER BY id")->result(); 
			
			$this->load->view('cetak_surat_masuk', $a);
		}
	}
	public function agenda_surat_masuk() {
		$a['page']	= "f_config_cetak_agenda";
		$this->load->view('header', $a);
	} 

	
	public function cetak_agenda() {
		$jenis_surat	= $this->input->post('tipe');
		$tgl_start		= $this->input->post('tgl_start');
		$tgl_end		= $this->input->post('tgl_end');
		

		$a['tgl_start']	= $tgl_start;
		$a['tgl_end']	= $tgl_end;	
		

		if ($jenis_surat == "agenda_surat_masuk") {	
			$a['data']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE usulan_masuk >= '$tgl_start' AND usulan_masuk <= '$tgl_end'  ORDER BY id")->result(); 
		
			$this->load->view('agenda_surat_masuk', $a);
		} else {
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE tgl_catat >= '$tgl_start' AND tgl_catat <= '$tgl_end' ORDER BY id")->result();
			$this->load->view('agenda_surat_keluar', $a);
		}
	}


	public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_admin")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
	
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$username				= addslashes($this->input->post('username'));
		$pass_raw1				= addslashes($this->input->post('password'));
		$pass_raw2				= addslashes($this->input->post('password2'));
		$password				= md5(addslashes($this->input->post('password')));
		$nama					= addslashes($this->input->post('nama'));
		$level					= addslashes($this->input->post('level'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('surat/manage_admin');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_admin WHERE nama LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_manage_admin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_admin WHERE id = '$idu'")->row();	
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "del") {
			$a['datpil']	= $this->db->query("DELETE FROM t_admin WHERE id = '$idu'")->row();	
			
			redirect('surat/manage_admin');
		} else if ($mau_ke == "act_add") {	
			$cek_user_exist = $this->db->query("SELECT username FROM t_admin WHERE username = '$username'")->num_rows();

			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
			} else if (strlen($pass_raw1) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password minimal 4 huruf</div>");
			} else if ($pass_raw1 != $pass_raw2) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password konfirmasi tidak sama..</div>");
			} else if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username telah dipakai. Ganti yang lain..!</div>");
			} else {
				$this->db->query("INSERT INTO t_admin VALUES (NULL, '$username', '$password', '$nama', '$level')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('surat/manage_admin');
		} else if ($mau_ke == "act_edt") {
			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
			} else if (strlen($pass_raw1) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password minimal 4 huruf</div>");
			} else if ($pass_raw1 != $pass_raw2) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password konfirmasi tidak sama..</div>");
			} else {
				
				if ($pass_raw1 == "") {
					$this->db->query("UPDATE t_admin SET username = '$username', nama = '$nama', level = '$level' WHERE id = '$idp'");
				} else {
					$this->db->query("UPDATE t_admin SET username = '$username', password = '$password', nama = '$nama', level = '$level' WHERE id = '$idp'");
				}

				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('surat/manage_admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('header', $a);
	}


	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("login");
		}		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		
		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$nama					= addslashes($this->input->post('nama'));
		$alamat					= addslashes($this->input->post('alamat'));
		$pimpinan				= addslashes($this->input->post('pimpinan'));
		$nik					= addslashes($this->input->post('nik'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('logo')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat',pimpinan ='$pimpinan' ,nik='$nik' logo = '".$up_data['file_name']."' WHERE id = '$idp'");

			} else {
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat',pimpinan ='$pimpinan' ,nik='$nik' WHERE id = '$idp'");
			}		

			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('surat/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('header', $a);	
	}
}


?>