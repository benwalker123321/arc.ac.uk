<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class studentTimetable extends CI_Controller {

	public function index()
	{
		$this->load->view('studentTimetable');
		$this->load->helper('url');
             
	}
}
