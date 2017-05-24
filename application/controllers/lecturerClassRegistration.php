<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lecturerClassRegistration extends CI_Controller {

	public function index()
	{
            
		$this->load->view('lecturerClassRegistration');
              
		$this->load->helper('url');
                
	}
}
