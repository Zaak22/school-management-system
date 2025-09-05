<?php 

class Model_Attendance extends CI_Model 
{
	protected static $PRESENT = 1;
	protected static $ABSENT = 2;
	protected static $LATE = 3;
	protected static $STUDENTS_TYPE = 1;
	protected static $TEACHERS_TYPE = 2;

	public function __construct()
	{
		parent::__construct();
	}

	/*
	*----------------------------------------------
	* create the attendance 
	* for student and teacher
	*----------------------------------------------
	*/
	public function createAttendance($typeId = null)
	{	
		if($typeId == 1) {
			// student
			for($x = 1; $x <= count($this->input->post('studentId')); $x++) {						

				$this->db->delete('attendance', array(
					'attendance_date' => $this->input->post('date'), 
					'class_id' => $this->input->post('classId'), 
					'section_id' => $this->input->post('sectionId'), 
					'student_id' => $this->input->post('studentId')[$x]
				));

				$insert_data = array(				
					'attendance_type' 	=> $this->input->post('attendance_type'),
					'student_id'		=> $this->input->post('studentId')[$x],						
					'class_id'			=> $this->input->post('classId'),
					'section_id'        => $this->input->post('sectionId'),
					'attendance_date'	=> $this->input->post('date'),
					'mark' 				=> $this->input->post('attendance_status')[$x]			
				);

				$status = $this->db->insert('attendance', $insert_data);						
			} // /for

			return ($status == true ? true : false);
		}
		else if($typeId == 2) {
			// teacher
			for($x = 1; $x <= count($this->input->post('teacherId')); $x++) {						

				$this->db->delete('attendance', array(
					'attendance_date' => $this->input->post('date'), 
					'class_id' => $this->input->post('classId'), 
					'section_id' => $this->input->post('sectionId'), 
					'student_id' => $this->input->post('studentId')[$x]
				));

				$insert_data = array(				
					'attendance_type' 	=> $this->input->post('attendance_type'),
					'teacher_Id'		=> $this->input->post('teacherId')[$x],					
					'attendance_date'	=> $this->input->post('date'),
					'mark' 				=> $this->input->post('attendance_status')[$x]			
				);

				$status = $this->db->insert('attendance', $insert_data);						
			} // /for

			return ($status == true ? true : false);
		}		
	}

	/*
	*----------------------------------------------
	* fetches the marked attendance	
	*----------------------------------------------
	*/
	public function fetchMarkAttendance($classId = null, $sectionId = null, $date = null, $typeId = null, $studentId = null, $teacherId = null)
	{		
		if($typeId == 1) {
			// student
			if($classId && $sectionId && $date && $typeId) {
				$sql = "SELECT * FROM attendance WHERE class_id = ? AND section_id = ? AND attendance_date = ? AND attendance_type = ? AND student_id = ?";
				$query = $this->db->query($sql, array($classId, $sectionId, $date, $typeId, $studentId));
				return $query->row_array();
			}
		}
		else if($typeId == 2) {
			// teacehr
			if($teacherId && $date && $typeId) {
				$sql = "SELECT * FROM attendance WHERE attendance_date = ? AND attendance_type = ? AND teacher_id = ?";
				$query = $this->db->query($sql, array($date, $typeId, $teacherId));
				return $query->row_array();
			}
		}			
	}

	public function getAttendance($day = null, $reportDate = null, $candidateId = null, $typeId = null, $classId = null, $sectionId = null) {				
		
		$year = substr($reportDate, 0, 4);
		$month = substr($reportDate, 5, 7);					

		if($day < 10) {
			$day = "0".$day;
		} else {
			$day = $day;
		}

		if($typeId == 1) {
			// student		
			
			$sql = "SELECT * FROM attendance WHERE 
				date_format(attendance_date, '%Y-%m-%d') = '{$year}-{$month}-{$day}'		
				AND class_id = {$classId}
				AND section_id = {$sectionId}
				AND student_id = {$candidateId}			
				AND attendance_type = {$typeId}			
			";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		else if($typeId == 2) {
			// teacher
			$sql = "SELECT * FROM attendance WHERE 
				date_format(attendance_date, '%Y-%m-%d') = '{$year}-{$month}-{$day}'					
				AND teacher_id = {$candidateId}
				AND attendance_type = {$typeId}			
			";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
			
	}

	/*
	*------------------------------------------------
	* fetch the daily summary of absens and presents 
	*------------------------------------------------
	*/
	public function getStudentDailySummery($start, $end, $classId=null)
	{
		$this->db->select('attendance_date, 
				SUM(CASE WHEN mark="' . self::$PRESENT . '" THEN 1 ELSE 0 END) as present,
				SUM(CASE WHEN mark="' . self::$ABSENT . '" THEN 1 ELSE 0 END) as absent,
				SUM(CASE WHEN mark="' . self::$LATE . '" THEN 1 ELSE 0 END) as late')
			->from('attendance')
			->where('attendance_type =', self::$STUDENTS_TYPE)
			->where('attendance_date >=', $start)
			->where('attendance_date <=', $end);
			

		if($classId) {
			$this->db->where('class_id = ', $classId);
		}

		$this->db->group_by('attendance_date');

		return $this->db->get()->result_array();
	}
}