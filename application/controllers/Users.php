<?php 

/**
 * @property Model_users model_users
 * @property Model_permissions model_permissions
 * @property Model_Roles model_roles
 */
class Users extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// loading the users model
		$this->load->model('model_users');

		// loading the permissions model
		$this->load->model('model_permissions');

		// loading the roles model
		$this->load->model('model_roles');

		// loading the form validation library
		$this->load->library('form_validation');		

	}

	public function login()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|callback_validate_username'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if($this->form_validation->run() === true) {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$login = $this->model_users->login($username, $password);
			if($login) {
				$this->load->library('session');

				$user_data = array(
					'id' => $login['user_id'],
					'logged_in' => true,
					'role' => $login['role_name'],
					'permissions' => $this->model_permissions->getPermeissionsForUser($login['user_id']),
				);

				$this->session->set_userdata($user_data);

				$validator['success'] = true;
				$validator['messages'] = "index.php/dashboard";				
			}	
			else {
				$validator['success'] = false;
				$validator['messages'] = "Incorrect username/password combination";
			} // /else

		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	} // /lgoin function

	public function validate_username()
	{
		$validate = $this->model_users->validate_username($this->input->post('username'));

		if($validate === true) {
			return true;
		} 
		else {
			$this->form_validation->set_message('validate_username', 'The {field} does not exists');
			return false;			
		} // /else
	} // /validate username function

	public function logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}


	public function updateProfile()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('id');

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required'
			),
			array(
				'field' => 'fname',
				'label' => 'First Name',
				'rules' => 'required'
			),
			array(
				'field' => 'role_id',
				'label' => 'Role',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
			$update = $this->model_users->updateProfile($userId);
			$role = $this->model_roles->getById($this->input->post('role_id'));		
				
			if($update === true) {
				$user_data = array(
					'id' => $userId,
					'logged_in' => true,
					'role' => $role['role_name'],
					'permissions' => $this->model_permissions->getPermeissionsForUser($userId),
				);

				$this->session->set_userdata($user_data);
				$validator['success'] = true;
				$validator['messages'] = "Successfully Update";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	}

	public function changePassword()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('id');

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'currentPassword',
				'label' => 'Current Password',
				'rules' => 'required|callback_validate_current_password'
			),
			array(
				'field' => 'newPassword',
				'label' => 'Password',
				'rules' => 'required|matches[confirmPassword]'
			),
			array(
				'field' => 'confirmPassword',
				'label' => 'Confirm Password',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');		

		if($this->form_validation->run() === true) {	
			$update = $this->model_users->changePassword($userId);					
			if($update === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Update";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	}

	public function validate_current_password()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('id');
		$validate = $this->model_users->validate_current_password($this->input->post('currentPassword'), $userId);

		if($validate === true) {
			return true;
		} 
		else {
			$this->form_validation->set_message('validate_current_password', 'The {field} is incorrect');
			return false;			
		} // /else	
	}


	/*
	*------------------------------------
	* retrieves users information 
	*------------------------------------
	*/
	public function fetchUserData($userId = null)
	{
		if($userId) {
			$result = $this->model_users->fetchUserData($userId);			
		}
		else {
			$userData = $this->model_users->fetchUserData();
			$result = array('data' => array());

			foreach ($userData as $key => $value) {
				
				$button = '<!-- Single button -->
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a type="button" data-toggle="modal" data-target="#updateUserModal" onclick="editUser('.$value['user_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
					    <li><a type="button" data-toggle="modal" data-target="#removeUserModal" onclick="removeUser('.$value['user_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
					  </ul>
					</div>';

				$result['data'][$key] = array(
					$value['user_id'],
					$value['username'],
					$value['fname'] . ' ' . $value['lname'],
					$value['email'],				
					$value['role_name'],				
					$button
				);			
			} // /foreach
		}			

		echo json_encode($result);
	}

	/*
	*------------------------------------
	* inserts the users information
	* into the database 
	*------------------------------------
	*/
	public function create()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required'
			),
			array(
				'field' => 'fname',
				'label' => 'First Name',
				'rules' => 'required'
			),
			array(
				'field' => 'lname',
				'label' => 'Last Name',
				'rules' => 'required'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			),
			array(
				'field' => 'role_id',
				'label' => 'Role',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {				
			$create = $this->model_users->create();					
			if($create == true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} 

		echo json_encode($validator);
	}

	/*
	*------------------------------------
	* updates user information
	*------------------------------------
	*/
	public function updateInfo($userId = null)
	{
		if($userId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'editUsername',
					'label' => 'Username',
					'rules' => 'required'
				),
				array(
					'field' => 'editFname',
					'label' => 'First Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editLname',
					'label' => 'Last Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editEmail',
					'label' => 'Email',
					'rules' => 'required'
				),
				array(
					'field' => 'editRoleId',
					'label' => 'Role',
					'rules' => 'required'
				),
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {							
				$updateInfo = $this->model_users->updateInfo($userId);					
				if($updateInfo == true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}			
			} 	
			else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}			
			}
			echo json_encode($validator);
		}					
	}

	/*
	*------------------------------------
	* removes user's information 
	*------------------------------------
	*/
	public function remove($UserId = null)
	{
		$validator = array('success' => false, 'messages' => array());

		if($UserId) {
			$remove = $this->model_users->remove($UserId);
			if($remove) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} 
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";	
			}
		}

		echo json_encode($validator);		
	}

}