<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lecturerAttendanceInfo extends CI_Controller {

	public function index()
	{
		$this->load->view('lecturerAttendanceInfo');
              
		$this->load->helper('url');
                
	}
}
