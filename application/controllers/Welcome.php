<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}

	// 로그인 페이지
	public function login()
	{
		$this->load->view('welcome/head');
		$this->load->view('welcome/login');
		$this->load->view('welcome/footer');
	}

	// 일반 사용자 회원가입 페이지
	public function signup()
	{
		$this->load->view('welcome/head');
		$this->load->view('welcome/signup');
		$this->load->view('welcome/footer');
	}

	// 서비스 관리자 회원가입 페이지
	public function provider_signup()
	{
		$this->load->view('welcome/head');
		$this->load->view('welcome/provider_signup');
		$this->load->view('welcome/footer');
	}
}
