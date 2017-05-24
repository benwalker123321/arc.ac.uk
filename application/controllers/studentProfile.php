<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class studentProfile extends CI_Controller {

	public function index()
	{
		$this->load->view('studentProfile');
              
		$this->load->helper('url');
                
	}
}
