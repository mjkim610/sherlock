<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();

      if($this->session->userdata('user_type') != 'user')
      {
        $this->session->set_flashdata('message', '잘못된 접근입니다');
        redirect('/');
      }
      $this->load->model('user_model');
	}

	public function fingerprint()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('user/body');
		$this->load->view('home/footer');
	}
}
