<?php

class Model_Roles extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getById($roleId)
	{
		return $this->db->select('*')->from('roles')->where('role_id', $roleId)->get()->row_array();
	}

	public function getAllRoles()
	{
		return $this->db->select('*')->from('roles')->get()->result_array();
	}
}
