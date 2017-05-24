<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class classManagementPage extends CI_Controller {

	public function index()
	{
		$this->load->view('classManagementPage');             
		$this->load->helper('url');
                
	}
}
