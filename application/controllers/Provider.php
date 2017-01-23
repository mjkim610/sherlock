<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();

      if($this->session->userdata('user_type') != 'provider')
      {
        $this->session->set_flashdata('message', '잘못된 접근입니다');
        redirect('/');
      }
      $this->load->model('provider_model');
	}

	public function my_app()
	{
		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('provider/body');
		$this->load->view('home/footer');
	}
}
