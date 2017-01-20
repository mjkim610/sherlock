<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
	    header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

	    parent::__construct();
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($what = 'signup')
	{
		if($what == 'signup')
		{
			$this->load->view('signup');
		}
		else
		{
			$this->load->view('login');
		}
	}

	public function init()
	{
		$appKey = $this->input->post('appKey');

		$this->load->model('sherlock_model');
		$token = $this->sherlock_model->init($appKey);

		echo $token;
	}

	public function api_signup()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
			'required'      => '이메일을 입력해 주세요.',
			'valid_email'   => '이메일 형식이 잘못되었습니다.'
		));
		$this->form_validation->set_rules('password', 'password', 'required', array(
			'required'      => '비밀번호를 입력해 주세요.'
		));
		$this->form_validation->set_rules('pin', 'pin', 'required|exact_length[4]|numeric', array(
			'required'      => '핀번호를 입력해 주세요.',
			'exact_length'      => '핀번호는 네자리 숫자만 가능합니다.',
			'numeric'      => '핀번호는 숫자만 가능합니다.'
		));
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('error', validation_errors()));
			exit();
		}

    $posts = $this->input->post();
    $fp_indexes = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a_a');
    $fps = [];
    foreach ($fp_indexes as $fp_index) {
      if($posts[$fp_index])
      {
        $fps[$fp_index] = $posts[$fp_index];
      }
      else {
        // ntbf.예외처리
        $fps[$fp_index] = '';
      }
    }

		$datas = array(
			'email' => $posts['email'],
			'password' => $posts['password'],
			'pin' => $posts['pin'],
			'fps' => $fps,
			'token' => $posts['token']
		);

		$this->load->model('sherlock_model');
		$res = $this->sherlock_model->signup($datas);

		echo json_encode($res);
	}

	public function api_login()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
			'required'      => '이메일을 입력해 주세요.',
			'valid_email'   => '이메일 형식이 잘못되었습니다.'
		));

		if($this->input->post('loginType') == 'password')
		{
			$this->form_validation->set_rules('password', 'password', 'required', array(
				'required'      => '비밀번호를 입력해 주세요.'
			));
		}

		if($this->input->post('loginType') == 'pin')
		{
			$this->form_validation->set_rules('pin', 'pin', 'required|exact_length[4]|numeric', array(
				'required'      => '핀번호를 입력해 주세요.',
				'exact_length'      => '핀번호는 네자리 숫자만 가능합니다.',
				'numeric'      => '핀번호는 숫자만 가능합니다.'
			));
		}

		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('error', validation_errors()));
			exit();
		}

    $posts = $this->input->post();
    $fp_indexes = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a_a');
    $fps = [];
		foreach ($fp_indexes as $fp_index) {
      if($posts[$fp_index])
      {
        $fps[$fp_index] = $posts[$fp_index];
      }
      else {
        // ntbf.예외처리
        $fps[$fp_index] = '';
      }
    }

		$datas = array(
			'email' => $posts['email'],
			'password' => $posts['password'],
			'loginType' => $posts['loginType'],
			'pin' => $posts['pin'],
			'fps' => $fps,
			'token' => $posts['token']
		);

		$this->load->model('sherlock_model');
		$res = $this->sherlock_model->login($datas);

    echo json_encode($res);
	}

	public function auth($type = 'fp', $email = 'none', $token = 'none')
	{
		$datas = array(
			'type' => $type,
			'email' => $email,
			'token' => $token
		);
		$this->load->view('auth', $datas);
	}
}
