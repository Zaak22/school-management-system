<?php

class Model_Permissions extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function fetchPermissionData($permissionId = null)
	{
		if ($permissionId) {
			$sql = "SELECT * FROM permissions WHERE permission_id = ?";
			$query = $this->db->query($sql, array($permissionId));
			return $query->row_array();
		}
		$sql = "SELECT * FROM permissions";
		$query = $this->db->query($sql);
		return $query->result_array();
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

	public function getPermissionIdsForRole($roleId)
	{
		if (!$roleId) {
			return [];
		}

		$this->db->select('p.permission_id');
		$this->db->from('roles r');
		$this->db->join('role_permissions rp', 'r.role_id = rp.role_id');
		$this->db->join('permissions p', 'rp.permission_id = p.permission_id');
		$this->db->where('r.role_id', $roleId);
		$query = $this->db->get();

		$permissions = array_column($query->result_array(), 'permission_id');
		return $permissions;
	}
}
