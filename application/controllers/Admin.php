<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Admin', 'admin');
	}

	public function index()
	{
		$this->form_validation->set_rules('account', 'Email or Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) 
		{
			$this->load->view('admin/login');
		} 
		else
		{
			
		}
	}

	public function dashboard()
	{
		$this->load->view('admin/_partials/header');
		$this->load->view('admin/_partials/sidebar');
		$this->load->view('Admin/homeadmin');
		$this->load->view('admin/_partials/footer');
	}

	public function akun_admin()
	{
		$data['admin'] = $this->admin->data_admin();
		$this->load->view('admin/_partials/header');
		$this->load->view('admin/_partials/sidebar');
		$this->load->view('Admin/akun_admin', $data);
		$this->load->view('admin/_partials/footer');
	}
	public function tambah_admin()
	{
		$this->form_validation->set_rules('namalengkap', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('admin/_partials/header');
			$this->load->view('admin/_partials/sidebar');
			$this->load->view('Admin/tambah_admin');
			$this->load->view('admin/_partials/footer');
		} else {
			$data = array(
				'Nama_Lengkap' => $this->input->post('namalengkap'),
				'User_Name' => $this->input->post('username'),
				'Email' => $this->input->post('email'),
				'Password' => $this->input->post('password')
			);

			$this->admin->tambah_admin($data);
			redirect('admin/akun_admin');
		}
		
	}
	public function ubah_admin($id_admin = null)

	{
		$data['admin']=$this->admin->data_admin_perid($id_admin);

		$this->form_validation->set_rules('namalengkap', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('admin/_partials/header');
			$this->load->view('admin/_partials/sidebar');
			$this->load->view('Admin/ubah_admin',$data);
			$this->load->view('admin/_partials/footer');
		}else {
			$data = array(
				'Nama_Lengkap' => $this->input->post('namalengkap'),
				'User_Name' => $this->input->post('username'),
				'Email' => $this->input->post('email')

			);
			$this->admin->ubah_admin($data,$id_admin );
			redirect('admin/akun_admin');
		}
	}
	public function hapus_admin($id_admin = null)
	{
		$this->admin->hapus_admin($id_admin );
			redirect('admin/akun_admin');
	}
}
