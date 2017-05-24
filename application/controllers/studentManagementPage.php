<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class studentManagementPage extends CI_Controller {

	public function index()
	{
		$this->load->view('studentManagementPage');
              
		$this->load->helper('url');
                
	}
}
