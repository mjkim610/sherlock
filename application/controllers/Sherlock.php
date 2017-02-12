<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sherlock extends CI_Controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		parent::__construct();
		$this->load->model('sherlock_model');
	}

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

    $datas = array(
      'sherlock_type' => $sherlock_type,
      'token' => $token,
      'app_id' => $app_id
    );

		$head_datas = array(
			'title' => 'Sherlock API Login'
		);

		$this->load->view('auth/head', $head_datas);
    $this->load->view('auth/auth_login', $datas);
		$this->load->view('auth/footer');
  }

  public function auth_login()
  {
		$this->form_validation->set_rules('sherlock_type', 'sherlock_type', 'required', array(
					'required'      => 'sherlock_type error'
				));
		$this->form_validation->set_rules('token', 'token', 'required', array(
					'required'      => 'token error'
				));
		$this->form_validation->set_rules('app_id', 'app_id', 'required', array(
					'required'      => 'app_id error'
				));
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
					'required'      => 'Email required',
					'valid_email'   => 'Email not valid'
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
		 error_message_goto('Wrong approach 111', '/');

		$datas = array();
		$datas['sherlock_type'] = $this->input->post('sherlock_type');
		$datas['token'] = $this->input->post('token');
		$datas['app_id'] = $this->input->post('app_id');
		$datas['email'] = $this->input->post('email');
		$datas['password'] = $this->input->post('password');
		$datas['pin'] = $this->input->post('pin');

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

		if($res['state'] == 'success')
		{
			$new_url = $res['redirect_url'].'?id_token='.$res['id_token'].'&state=login';;
			redirect($new_url);
		}

		if($res['message'] == 'no user')
		 error_message_goto('No email. Please signup first', $this->input->post('redirect').'?sherlock_type='.$datas['sherlock_type'].'&token='.$datas['token'].'&app_id='.$datas['app_id']);
		else if($res['message'] == 'no fingerprint')
			error_message_goto('No fingerprint. Please regist fingerprint first', $this->input->post('redirect').'?sherlock_type='.$datas['sherlock_type'].'&token='.$datas['token'].'&app_id='.$datas['app_id']);
		else if($res['message'] == 'fp-password')
			error_message_goto('fingerprint score : '.$res['score'].'. Please enter password', $this->input->post('redirect').'?sherlock_type=password&token='.$datas['token'].'&app_id='.$datas['app_id']);
		else if($res['message'] == 'fp-pin')
			error_message_goto('fingerprint score : '.$res['score'].'. Please enter pin', $this->input->post('redirect').'?sherlock_type=pin&token='.$datas['token'].'&app_id='.$datas['app_id']);
		else if($res['message'] == 'pin wrong')
			error_message_goto('PIN number wrong. Please enter password', $this->input->post('redirect').'?sherlock_type=password&token='.$datas['token'].'&app_id='.$datas['app_id']);
		else if($res['message'] == 'password wrong')
			error_message_goto('Password wrong. Please enter password again', $this->input->post('redirect').'?sherlock_type=password&token='.$datas['token'].'&app_id='.$datas['app_id']);
		else if($res['message'] == 'no service user')
			redirect(site_url('authenticate/signup').'?token='.$datas['token'].'&app_id='.$datas['app_id'].'&id_token='.$res['id_token']);
		else
			error_message_goto('Nice try 112', '/');
		// ntbf exception for each case!!
  }

	public function auth_signup()
	{
		$token = $this->input->get('token');
		$app_id = $this->input->get('app_id');
		$id_token = $this->input->get('id_token');

		$datas = array(
			'token' => $token,
			'app_id' => $app_id,
			'id_token' => $id_token
		);

		$user_info = $this->sherlock_model->get_user_info_from_id_token_t($datas);
		if($user_info == 'no id token' || $user_info == 'no user')
		 error_message_goto('Wrong approach 113', '/');

		$service_info = $this->sherlock_model->get_service_info($datas);
		if($service_info == 'no service')
		 error_message_goto('Wrong approach 114', '/');

		$datas['user_info'] = $user_info;
		$datas['service_info'] = $service_info;

		$head_datas = array(
			'title' => 'Sherlock API Signup'
		);

		$this->load->view('auth/head', $head_datas);
		$this->load->view('auth/auth_signup', $datas);
		$this->load->view('auth/footer');
	}

	public function auth_signup_submit()
	{
		$token = $this->input->post('token');
		$app_id = $this->input->post('app_id');
		$id_token = $this->input->post('id_token');

		$datas = array(
			'token' => $token,
			'app_id' => $app_id,
			'id_token' => $id_token
		);

		// signup
		$res = $this->sherlock_model->signup_service($datas);
		if($res == 'db insert error')
		 error_message_goto($res, '/');
		else if($res == 'already done')
		 error_message_goto('you have already signed up', site_url('authenticate').'?sherlock_type=fingerprint&token='.$token.'&app_id='.$app_id);

		if($res == 'ok')
		{
			$service_info = $this->sherlock_model->get_service_info($datas);
			if($service_info == 'no service')
			 error_message_goto('Wrong approach 115', '/');

			$new_url = $service_info->redirect_url.'?id_token='.$id_token.'&state=signup';
			redirect($new_url);
		}
		else
		 error_message_goto('Wrong approach 116', '/');
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
		$state = $_GET["state"];

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
