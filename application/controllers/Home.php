<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}

	public function index()
 	{
		$this->load->view('home/head');
 		$this->load->view('home/nav');
		$this->load->view('home/main_body');
 		$this->load->view('home/footer');
 	}

	public function about()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('home/about');
		$this->load->view('home/footer');
	}

	public function about_dev()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('home/about_dev');
		$this->load->view('home/footer');
	}

	public function edit()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('home/edit_body');
		$this->load->view('home/footer');
	}
}
