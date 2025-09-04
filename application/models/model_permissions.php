<?php

class Model_Permissions extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getPermeissionsForUser($userId)
	{
		if (!$userId) {
			return [];
		}

		$this->db->select('p.permission_name');
		$this->db->from('users u');
		$this->db->join('roles r', 'u.role_id = r.role_id');
		$this->db->join('role_permissions rp', 'r.role_id = rp.role_id');
		$this->db->join('permissions p', 'rp.permission_id = p.permission_id');
		$this->db->where('u.user_id', $userId);
		$query = $this->db->get();

		$permissions = array_column($query->result_array(), 'permission_name');
		return $permissions;
	}
}
