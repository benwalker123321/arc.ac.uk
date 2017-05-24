<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class courses extends CI_Controller {

	public function index()
	{
		$this->load->view('courses');
		$this->load->helper('url');
             
	}
}
