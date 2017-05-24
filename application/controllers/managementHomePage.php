<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class managementHomePage extends CI_Controller {

	public function index()
	{
		$this->load->view('managementHomePage');
              
		$this->load->helper('url');
                
	}
}
