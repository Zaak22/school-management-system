<?php

/**
 * @property Model_Student_Transfer model_student_transfer
 */
class StudentTransfer extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the teacher model
		$this->load->model('model_student_transfer');
	}

	/*
	*------------------------------------
	* retrieves teacher information 
	*------------------------------------
	*/
	public function fetchStudentTransferData($studentId=null)
	{
		$transferData = $this->model_student_transfer->fetchStudentTransferData($studentId);
		$result = array('data' => array());
		foreach ($transferData as $key => $value) {
			$result['data'][$key] = array(
				'from_class_name' => $value['from_class_name'],
				'to_class_name'   => $value['to_class_name'],
				'from_section_name' => $value['from_section_name'],
				'to_section_name' => $value['to_section_name'],
				'reason' => $value['reason'],
				'transfer_at' => $value['transfer_at'],
				'student_full_name' => $value['student_fname'] . ' ' . $value['student_lname'],
			);
		}
		
		echo json_encode($result);
	}
}
