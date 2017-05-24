<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class attendanceManagementPage extends CI_Controller {

	public function index()
	{
		$this->load->view('attendanceManagementPage');
		$this->load->helper('url');

	}
}
