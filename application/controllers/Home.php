<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}

	// 메인 페이지
	public function index()
 	{
		$this->load->view('home/head');
 		$this->load->view('home/nav');
		$this->load->view('home/main_body');
 		$this->load->view('home/footer');
 	}

	// 일반 사용자 설명 페이지
	public function about()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('home/about');
		$this->load->view('home/footer');
	}

	// 개발자 설명 페이지
	public function about_dev()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('home/about_dev');
		$this->load->view('home/footer');
	}

	// 개인정보 수정 페이지
	public function edit()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('home/edit_body');
		$this->load->view('home/footer');
	}
}
