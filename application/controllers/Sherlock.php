<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sherlock extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}

	// public function index()
 // 	{
	// 	$this->load->view('home/head');
 // 		$this->load->view('home/nav');
	// 	$this->load->view('home/body');
 // 		$this->load->view('home/footer');
 // 	}

 	public function init()
 	{
 		$appKey = $this->input->post('appKey');

 		$this->load->model('sherlock_model');
 		$token = $this->sherlock_model->init($appKey);

 		echo $token;
 	}

  public function auth($type = 'fp', $email = 'none', $token = 'none')
  {
    $datas = array(
      'type' => $type,
      'email' => $email,
      'token' => $token
    );
    $this->load->view('auth/auth_login', $datas);
  }
}
