<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class signingIn extends CI_Controller {

	public function index()
	{
		$this->load->view('signingIn');
              
		$this->load->helper('url');
                
	}
}
