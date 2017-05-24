<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lecturerTimetable extends CI_Controller {

	public function index()
	{
		$this->load->view('lecturerTimetable');
              
		$this->load->helper('url');
                
	}
}
