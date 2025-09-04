<?php

class Model_Student_Transfer extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*------------------------------------
	* retrieves student transfer information 
	*------------------------------------
	*/
	public function fetchStudentTransferData($studentId = null)
	{
		$sql = "SELECT st.*,
               sc.fname AS student_fname,
               sc.lname AS student_lname,
               c_from.class_name AS from_class_name,
               s_from.section_name AS from_section_name,
               c_to.class_name AS to_class_name,
               s_to.section_name AS to_section_name
        FROM student_transfer st
        JOIN student sc ON st.student_id = sc.student_id
        JOIN class c_from ON st.from_class_id = c_from.class_id
        JOIN section s_from ON st.from_section_id = s_from.section_id
        JOIN class c_to ON st.to_class_id = c_to.class_id
        JOIN section s_to ON st.to_section_id = s_to.section_id";

		if ($studentId) {
			$sql .= " WHERE st.student_id = ? ";
		}

		$sql .= " ORDER BY st.transfer_at DESC";
		$query = $this->db->query($sql, (isset($studentId) ? array($studentId) : false));
		$result = $query->result_array();
		return $result;
	}
}
