<?php

/**
 * @property Model_roles model_roles
 * @property Model_permissions model_permissions
 * @property Model_Roles model_roles
 */
class Roles extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// loading the roles model
		$this->load->model('model_roles');

		// loading the permissions model
		$this->load->model('model_permissions');

		// loading the roles model
		$this->load->model('model_roles');

		// loading the form validation library
		$this->load->library('form_validation');
	}

	/*
	*------------------------------------
	* retrieves roles information 
	*------------------------------------
	*/
	public function fetchRoleData($roleId = null)
	{
		if ($roleId) {
			$result = $this->model_roles->fetchRoleData($roleId);
			$result['permissions'] = $this->model_permissions->getPermissionIdsForRole($roleId);
		} else {
			$roleData = $this->model_roles->fetchRoleData();
			$result = array('data' => array());

			foreach ($roleData as $key => $value) {

				$button = '<!-- Single button -->
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a type="button" data-toggle="modal" data-target="#updateRoleModal" onclick="editRole(' . $value['role_id'] . ')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
					    <li><a type="button" data-toggle="modal" data-target="#removeRoleModal" onclick="removeRole(' . $value['role_id'] . ')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
					  </ul>
					</div>';

				$result['data'][$key] = array(
					$value['role_id'],
					$value['role_name'],
					$button
				);
			} // /foreach
		}

		echo json_encode($result);
	}

	/*
	*------------------------------------
	* inserts the roles information
	* into the database 
	*------------------------------------
	*/
	public function create()
	{
		$validator = array('success' => false, 'messages' => array());

		$this->form_validation->set_rules(
			'role_name',
			'Role Name',
			'required|trim|is_unique[roles.role_name]',
			[
				'is_unique' => 'This role name already exists. Please choose another.'
			]
		);
		$this->form_validation->set_rules('permissions[]', 'Permissions', 'required|callback_validate_permissions');

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {
			$role_name      = $this->input->post('role_name');
			$permission_ids = $this->input->post('permissions');
			$create = $this->model_roles->create($role_name, $permission_ids);
			if ($create == true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			} else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($validator);
	}

	public function validate_permissions($permission_id)
	{
		if (!ctype_digit((string)$permission_id)) {
			$this->form_validation->set_message('validate_permissions', 'Permission IDs must be integers.');
			return false;
		}

		$count = $this->db
			->where('permission_id', $permission_id)
			->from('permissions')
			->count_all_results();

		if ($count === 0) {
			$this->form_validation->set_message('validate_permissions', "Permission ID {$permission_id} is invalid.");
			return false;
		}

		return true;
	}

	/*
	*------------------------------------
	* updates role information
	*------------------------------------
	*/
	public function updateInfo($roleId = null)
	{
		if ($roleId) {
			$validator = array('success' => false, 'messages' => array());

			$this->form_validation->set_rules('editRoleName', 'Role Name', 'required|trim|callback_validate_role_name_unique[' . $roleId . ']');
			$this->form_validation->set_rules('editPermissions[]', 'Permissions', 'required|callback_validate_permissions');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$role_name      = $this->input->post('editRoleName');
				$permission_ids = $this->input->post('editPermissions');
				$updateInfo = $this->model_roles->updateInfo($roleId, $role_name, $permission_ids);
				if ($updateInfo == true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				} else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}
			} else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}
			}
			echo json_encode($validator);
		}
	}

	public function validate_role_name_unique($role_name, $role_id)
	{
		$this->db->where('role_name', $role_name);
		$this->db->where('role_id !=', $role_id);
		$count = $this->db->count_all_results('roles');

		if ($count > 0) {
			$this->form_validation->set_message('validate_role_name_unique', 'This role name already exists.');
			return false;
		}

		return true;
	}

	/*
	*------------------------------------
	* removes role's information 
	*------------------------------------
	*/
	public function remove($RoleId = null)
	{
		$validator = array('success' => false, 'messages' => array());

		if ($RoleId) {
			$remove = $this->model_roles->remove($RoleId);
			if ($remove) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} else {
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";
			}
		}

		echo json_encode($validator);
	}
}
