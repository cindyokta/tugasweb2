<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Admin', 'admin');
	}

	private function _setAlert($status = NULL, $message = NULL)
	{
	    if ($status == 'success')
	    {
	        // For success alert
	        return $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" style="margin-bottom:5px;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '. $message .'</div>');
	    }
	    elseif ($status == 'warning')
	    {
	        // For warning alert
	        return $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" style="margin-bottom:5px;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> '. $message .'</div>');
	    }
	    else
	    {
	        // For danger alert
	        return $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" style="margin-bottom:5px;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> '. $message .'</div>');
	    }
	}

	public function index()
	{
		if ($this->session->has_userdata('logged_in')) {
			redirect('admin/dashboard');
		}

		$this->form_validation->set_rules('account', 'Email or Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) 
		{
			$data['title'] = "Login";

			$this->load->view('admin/login');
		} 
		else
		{
			$data = array 
			(
				'Email' => $this->input->post('account', true),
				'User_Name' => $this->input->post('account', true),
				'Password' => $this->input->post('password', true)
			);

			$result = $this->admin->login_admin($data);

			if ($result)
			{
				if (password_verify($data['Password'], $result['Password']))
                {
                	$session_data = array(
                        'id_admin' => $result['Id_Admin'],
                        'nama_lengkap' => $result['Nama_Lengkap'],
                        'logged_in' => true
                    );

                    $this->session->set_userdata($session_data);
                    $this->_setAlert('success', 'Welcome back, ' . $result['Nama_Lengkap']);
                    redirect('admin/dashboard');
                }
                else
                {
                	$this->_setAlert('warning', 'Password your entered not valid.');
					redirect('admin');
                }
			}
			else
			{
				$this->_setAlert('warning', 'Email or username your entered not valid.');
				redirect('admin');
			}
		}
	}

	public function logout()
    {
    	if (!$this->session->has_userdata('logged_in')) {
			redirect('admin');
		}

        $this->session->sess_destroy();
        redirect('admin');
    }

	public function dashboard()
	{
		if (!$this->session->has_userdata('logged_in')) {
			redirect('admin');
		}

		$data['title'] = "Dashboard";

		$this->load->view('admin/_partials/header', $data);
		$this->load->view('admin/_partials/sidebar');
		$this->load->view('Admin/homeadmin');
		$this->load->view('admin/_partials/footer');
	}

	public function akun_admin()
	{
		if (!$this->session->has_userdata('logged_in')) {
			redirect('admin');
		}

		$data['title'] = "Admin";
		$data['admin'] = $this->admin->data_admin();

		$this->load->view('admin/_partials/header', $data);
		$this->load->view('admin/_partials/sidebar');
		$this->load->view('Admin/akun_admin', $data);
		$this->load->view('admin/_partials/footer');
	}

	public function tambah_admin()
	{
		if (!$this->session->has_userdata('logged_in')) {
			redirect('admin');
		}

		$this->form_validation->set_rules('namalengkap', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[table_admin.User_Name]', array ('is_unique' => 'Username already exist'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[table_admin.Email]', array ('is_unique' => 'Email already exist'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

		if ($this->form_validation->run() == false)
		{
			$data['title'] = "Tambah Admin";

			$this->load->view('admin/_partials/header', $data);
			$this->load->view('admin/_partials/sidebar');
			$this->load->view('Admin/tambah_admin');
			$this->load->view('admin/_partials/footer');
		}
		else
		{
			$data = array 
			(
				'Nama_Lengkap' => ucwords($this->input->post('namalengkap', true)),
				'User_Name' => $this->input->post('username', true),
				'Email' => $this->input->post('email', true),
				'Password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT)
			);

			$this->admin->tambah_admin($data);
			$this->_setAlert('success', 'Data has been saved.');
			redirect('admin/akun_admin');
		}
		
	}

	public function ubah_admin($id_admin = null)
	{
		if (!$this->session->has_userdata('logged_in')) {
			redirect('admin');
		}

		$data['admin'] = $this->admin->data_admin($id_admin);

		$this->form_validation->set_rules('namalengkap', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if ($this->form_validation->run() == false) 
		{
			$data['title'] = "Ubah Admin";

			$this->load->view('admin/_partials/header', $data);
			$this->load->view('admin/_partials/sidebar');
			$this->load->view('Admin/ubah_admin', $data);
			$this->load->view('admin/_partials/footer');
		}
		else 
		{
			$data = array
			(
				'Nama_Lengkap' => $this->input->post('namalengkap'),
				'User_Name' => $this->input->post('username'),
				'Email' => $this->input->post('email')
			);

			$this->admin->ubah_admin($data, $id_admin);
			$this->_setAlert('success', 'Data has been updated.');
			redirect('admin/akun_admin');
		}
	}

	public function hapus_admin($id_admin = null)
	{
		if (!$this->session->has_userdata('logged_in')) {
			redirect('admin');
		}

		$this->admin->hapus_admin($id_admin);
		$this->_setAlert('success', 'Data has been deleted.');
		redirect('admin/akun_admin');
	}
}
