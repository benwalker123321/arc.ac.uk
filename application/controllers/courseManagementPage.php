<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class courseManagementPage extends CI_Controller {

	public function index()
	{
		$this->load->view('courseManagementPage');
              
		$this->load->helper('url');
                
	}
}
