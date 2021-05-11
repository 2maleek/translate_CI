<?php 

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
    }

    public function index(){
        $data = $this->Login_model->getInstansi();

        $data = [
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'logo' => $data['logo'],
        ];

        $this->load->view('login', $data);
    }

    public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
        $p 		= md5($this->security->xss_clean($this->input->post('p')));
         	
		$this->db->where('username', $u);
        $this->db->where('password', $p);
        
		$q_cek  = $this->Login_model->getAdmin();
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		
        if($j_cek == 1) {
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->nama,
                    'admin_level' => $d_cek->level,
					'admin_valid' => true
                    );
            $this->session->set_userdata($data);
            redirect('Surat');
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('Login');
		}
	}
	
	public function logout(){
        $this->session->sess_destroy();
		redirect('Login');
	}

}

?>