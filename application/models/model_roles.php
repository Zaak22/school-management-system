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

	public function fetchRoleData($roleId = null)
	{
		if ($roleId) {
			$sql = "SELECT * FROM roles WHERE role_id = ?";
			$query = $this->db->query($sql, array($roleId));
			return $query->row_array();
		}
		$sql = "SELECT * FROM roles";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function fetchRoleDataByName($roleName)
	{
		$result = $this->db->from('roles')->where('role_name', $roleName)->get()->row_array();
		return $result;
	}

	/*
	*------------------------------------
	* insert roles data into db
	*------------------------------------
	*/
	public function create($role_name, $permissions)
	{
		$this->db->trans_start();

		$this->db->insert('roles', ['role_name' => $role_name]);
		$role_id = $this->db->insert_id();

		if (!empty($permissions)) {
			$batch = [];
			foreach ($permissions as $perm) {
				$batch[] = [
					'role_id'       => $role_id,
					'permission_id' => $perm
				];
			}

			if (!empty($batch)) {
				$this->db->insert_batch('role_permissions', $batch);
			}
		}

		$this->db->trans_complete();

		return $this->db->trans_status();
	}


	/*
	*------------------------------------
	* updates roles information
	*------------------------------------
	*/
	public function updateInfo($role_id = null, $role_name, $permission_ids)
	{
		$this->db->trans_start();

		$this->db->where('role_id', $role_id);
		$this->db->update('roles', ['role_name' => $role_name]);

		$existing = $this->db->select('permission_id')
			->where('role_id', $role_id)
			->get('role_permissions')
			->result_array();

		$existing_ids = array_column($existing, 'permission_id');

		$to_add    = array_diff($permission_ids, $existing_ids);
		$to_remove = array_diff($existing_ids, $permission_ids);

		if (!empty($to_remove)) {
			$this->db->where('role_id', $role_id);
			$this->db->where_in('permission_id', $to_remove);
			$this->db->delete('role_permissions');
		}

		if (!empty($to_add)) {
			$batch = [];
			foreach ($to_add as $pid) {
				$batch[] = ['role_id' => $role_id, 'permission_id' => $pid];
			}
			$this->db->insert_batch('role_permissions', $batch);
		}

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/*
	*------------------------------------
	* removes role's information 
	*------------------------------------
	*/
	public function remove($roleId = null)
	{
		if ($roleId) {
			$this->db->where('role_id', $roleId);
			$result = $this->db->delete('roles');
			return ($result === true ? true : false);
		}
	}
}
