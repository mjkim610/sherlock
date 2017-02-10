<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sherlock extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('sherlock_model');
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
 		$app_id = $this->input->post('app_id');

 		$token = $this->sherlock_model->init($app_id);

 		echo $token;
 	}

  public function auth()
  {
		$sherlock_type = $this->input->get('sherlock_type');
		$token = $this->input->get('token');
		$app_id = $this->input->get('app_id');
		// $redirect_uri = $this->input->get('redirect_uri');

    $datas = array(
      'sherlock_type' => $sherlock_type,
      'token' => $token,
      'app_id' => $app_id
      // 'redirect_uri' => $redirect_uri
    );

		$this->load->view('auth/head');
    $this->load->view('auth/auth_login', $datas);
		$this->load->view('auth/footer');
  }

  public function auth_login()
  {
		$this->form_validation->set_rules('sherlock_type', 'sherlock_type', 'required', array(
					'required'      => '다시 시도해주세요(type error)'
				));
		$this->form_validation->set_rules('token', 'token', 'required', array(
					'required'      => '다시 시도해주세요(token error)'
				));
		$this->form_validation->set_rules('app_id', 'app_id', 'required', array(
					'required'      => '다시 시도해주세요(app_id error)'
				));
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
					'required'      => '이메일을 입력해 주세요',
					'valid_email'   => '이메일 형식이 잘못되었습니다'
				));

		if ($this->form_validation->run() == FALSE)
		{
			$arr = '';
			foreach ($this->form_validation->error_array() as $error)
			{
				$arr .= "<div class='alert'>";
				$arr .= "<span class='closebtn'>&times;</span>";
				$arr .= "<span>".$error."</span>";
				$arr .= "</div>";
			}
			$this->session->set_flashdata('errors', $arr);
			redirect($this->input->post('redirect').'?sherlock_type='.$this->input->post('sherlock_type').'&token='.$this->input->post('token'));
		}

		if( ! in_array($this->input->post('sherlock_type'), array('fingerprint', 'pin', 'password')))
		{
			$this->session->set_flashdata('message', 'wrong approach');
			redirect('/');
		}

		$datas = array();
		$datas['sherlock_type'] = $this->input->post('sherlock_type');
		$datas['token'] = $this->input->post('token');
		$datas['app_id'] = $this->input->post('app_id');
		$datas['email'] = $this->input->post('email');
		$datas['password'] = $this->input->post('password');
		$datas['pin'] = $this->input->post('pin');

		// post 받을 준비
		$labels = array();
		for($i = 1; $i <= 24; $i++)
		{
			$labels[] = 'fp_'.$i;
		}
		$labels[] = 'title';

		foreach ($labels as $label)
		{
			$datas[$label] = $this->input->post($label);
		}

		// --ip part
		$ips = $this->input->ip_address();
		if($ips == '::1') $ips = '127.0.0.1';
		$ip_arr = explode('.', $ips);
		$ip_labels = array(
			0 => 'fp_25',
			1 => 'fp_26',
			2 => 'fp_27',
			3 => 'fp_28'
		);

		foreach ($ip_labels as $key=>$value)
		{
			$datas[$value] = $ip_arr[$key];
		}
		// --ip part

		$res = $this->sherlock_model->compare_fingerprint($datas);
		// echo var_dump($res);
		if($res['state'] == 'success')
		{
			$new_url = $res['url'].'?id_token='.$res['id_token'];
			redirect($new_url);
		}

		if($res['message'] == 'no user')
		{
			$this->session->set_flashdata('message', 'No email. Please signup first.');
			redirect($this->input->post('redirect').'?sherlock_type='.$datas['sherlock_type'].'&token='.$datas['token'].'&app_id='.$datas['app_id']);
		}
		else if($res['message'] == 'no fingerprint')
		{
			$this->session->set_flashdata('message', 'No fingerprint. Please regist fingerprint first.');
			redirect($this->input->post('redirect').'?sherlock_type='.$datas['sherlock_type'].'&token='.$datas['token'].'&app_id='.$datas['app_id']);
		}
		else if($res['message'] == 'fp-password')
		{
			$this->session->set_flashdata('message', 'fingerprint score : '.$res['score'].'. Please enter password');
			redirect($this->input->post('redirect').'?sherlock_type=password&token='.$datas['token'].'&app_id='.$datas['app_id']);
		}
		else if($res['message'] == 'fp-pin')
		{
			$this->session->set_flashdata('message', 'fingerprint score : '.$res['score'].'. Please enter pin');
			redirect($this->input->post('redirect').'?sherlock_type=pin&token='.$datas['token'].'&app_id='.$datas['app_id']);
		}
		else if($res['message'] == 'pin wrong')
		{
			$this->session->set_flashdata('message', 'PIN number wrong. Please enter password');
			redirect($this->input->post('redirect').'?sherlock_type=password&token='.$datas['token'].'&app_id='.$datas['app_id']);
		}
		else if($res['message'] == 'password wrong')
		{
			$this->session->set_flashdata('message', 'password wrong. Please enter password again');
			redirect($this->input->post('redirect').'?sherlock_type=password&token='.$datas['token'].'&app_id='.$datas['app_id']);
		}
		else
		{
			$this->session->set_flashdata('message', 'Nice try');
			redirect('/');
		}
		// ntbf exception for each case!!

  }

	public function send_user_profile()
	{
		$id_token = $this->input->post('id_token');
		$app_id = $this->input->post('app_id');

		$datas = array(
			'id_token' => $id_token,
			'app_id' => $app_id
		);

		$res = $this->sherlock_model->get_user_profile($datas);
		if($res['state'] == 'success')
		{
			echo $res['data'];
		}
		else
		{
			echo $res['message'];
		}
	}

	// code for service provider php server
	public function auth_complete()
	{
		$id_token = $_GET["id_token"];

		$postdata = http_build_query(
			array(
				'id_token' => $id_token,
				'app_id' => 'asd23fgasdgasf32'
			)
		);

		$opts = array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context  = stream_context_create($opts);
		// $result = file_get_contents('http://try-sherlock.com/get_user_profile', false, $context);
		$result = file_get_contents(site_url('get_user_profile'), false, $context);

		echo $result;
	}
}
