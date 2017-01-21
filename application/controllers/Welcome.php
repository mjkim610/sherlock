<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}

	public function index()
 	{

 	}

	public function login()
	{
		$this->load->view('login');
	}

	public function signup()
	{
		$this->load->view('signup');
	}
}
