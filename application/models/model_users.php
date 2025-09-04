<?php 

class Model_Users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	/*
	*------------------------------------
	* inserts the users information into the database 
	*------------------------------------
	*/
	public function create()
	{
		$insert_data = array(
			'username' 		=> $this->input->post('username'),
			'fname' 		=> $this->input->post('fname'),
			'lname'			=> $this->input->post('lname'),
			'email'			=> $this->input->post('email'),
			'role_id'		=> $this->input->post('role_id'),
			'password'		=> md5($this->input->post('password')),
		);

		$status = $this->db->insert('users', $insert_data);		
		return ($status == true ? true : false);
	}

	public function validate_username($username = null)
	{
		if($username) {			
			// die($username);
			$sql = "SELECT * FROM users WHERE username = ?";
			$query = $this->db->query($sql, array($username));
			$result = $query->row_array();
			
			return ($query->num_rows() === 1 ? true : false);			
		}	
		else {
			return false;
		}
	} // /validate username function

	
	public function validate_current_password($password = null, $userId = null)
	{
		if($password && $userId) {			
			$password = md5($this->input->post('currentPassword'));									

			$sql = "SELECT * FROM users WHERE password = ? AND user_id = ?";
			$query = $this->db->query($sql, array($password, $userId));
			$result = $query->row_array();
			
			return ($query->num_rows() === 1 ? true : false);			
		}	
		else {
			return false;
		}
	} // /validate username function

	public function login($username = null, $password = null) 
	{
		if($username && $password) {
			$sql = "SELECT * FROM users JOIN roles on roles.role_id = users.role_id WHERE username = ? AND password = ?";
			$query = $this->db->query($sql, array($username, $password));
			$result = $query->row_array();

			return ($query->num_rows() === 1 ? $result : false);
		}
		else {
			return false;
		}
	}

	public function fetchUserData($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM users WHERE user_id = ?";
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
		$sql = "SELECT * FROM users JOIN roles on roles.role_id = users.role_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function updateProfile($userId = null)
	{
		if($userId) {
			$update_data = array(
				'username' => $this->input->post('username'),
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'email' => $this->input->post('email'),
				'role_id' => $this->input->post('role_id')
			);

			$this->db->where('user_id', $userId);
			$status = $this->db->update('users', $update_data);
			return ($status == true ? true : false);
		}
	}

	public function changePassword($userId = null)
	{
		if($userId) {
			$password = md5($this->input->post('newPassword'));
			$update_data = array(
				'password' => $password
			);

			$this->db->where('user_id', $userId);
			$status = $this->db->update('users', $update_data);
			return ($status == true ? true : false);
		}
	}

	/*
	*------------------------------------
	* updates useres information
	*------------------------------------
	*/
	public function updateInfo($userId = null)
	{
		if ($userId) {
			$update_data = array(
				'username' 			=> $this->input->post('editUsername'),
				'fname' 			=> $this->input->post('editFname'),
				'lname' 			=> $this->input->post('editLname'),
				'email'				=> $this->input->post('editEmail'),
				'role_id'			=> $this->input->post('editRoleId'),
			);

			if ($this->input->post('editPassword')) {
				$update_data['password'] = md5($this->input->post('editPassword'));
			}

			$this->db->where('user_id', $userId);
			$query = $this->db->update('users', $update_data);

			return ($query === true ? true : false);
		}
	}

	/*
	*------------------------------------
	* removes user's information 
	*------------------------------------
	*/
	public function remove($userId = null)
	{
		if($userId) {
			$this->db->where('user_id', $userId);
			$result = $this->db->delete('users');
			return ($result === true ? true: false); 
		}
	}
}