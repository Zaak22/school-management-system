<?php

/**
 * @property Model_Attendance model_attendance
 * @property model_accounting model_accounting
 */
class Dashboard extends MY_Controller
{

	/*
	*------------------------------------------------
	* fetch the daily summary of absens and presents 
	*------------------------------------------------
	*/
	public function getStudentDailySummery()
	{
		$this->load->model('model_attendance');

		$start 		= $this->input->post('start');
		$end   		= $this->input->post('end');
		$class_id   = $this->input->post('class_id');
		
		$result = $this->model_attendance->getStudentDailySummery($start, $end, $class_id);

		$events = [];
		foreach ($result as $day) {
			$events[] = [
				'start' => $day['attendance_date'],
				'allDay' => true,
				'present' => $day['present'],
				'absent' => $day['absent'],
				'late' => $day['late']
			];
		}

		echo json_encode($events);
	}
}
