<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staffManagementPage extends CI_Controller {

	public function index()
	{
		$this->load->view('staffManagementPage');             
		$this->load->helper('url');
                
	}
}
