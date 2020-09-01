<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('display_errors',1);

class Principal extends CI_Controller{
	
	public function index(){

		$this->layout = 'Dashboard';

		$this->load->view('welcome_message');

	}
}