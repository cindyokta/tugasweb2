<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Admin extends CI_Model {

	public function data_admin()
	{
		return $this->db->get('table_admin')->result_array();
	}

	public function tambah_admin($data)
	{
		$this->db->insert('table_admin', $data);
		return $this->db->affected_rows();
	}

	public function data_admin_perid($id_admin)
	{
		return $this->db->get_where('table_admin',['Id_Admin'=>$id_admin])->row_array();
	}

	public function ubah_admin($data, $id_admin)
	{
		$this->db->update('table_admin', $data, ['Id_Admin'=>$id_admin]);
		return $this->db->affected_rows();
	}
	public function hapus_admin($id_admin)
	{
		$this->db->delete('table_admin', ['Id_Admin'=>$id_admin]);
		return $this->db->affected_rows();
	}
}

