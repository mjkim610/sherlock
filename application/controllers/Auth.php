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

	public function signup()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
	        'required'      => '이메일을 입력해 주세요',
	        'valid_email'   => '이메일 형식이 잘못되었습니다'
	      ));
		$this->form_validation->set_rules('password', 'password', 'required|min_length[7]|max_length[30]', array(
	        'required'      => '비밀번호를 입력해 주세요',
	        'min_length'    => '비밀번호는 7자 이상입니다',
	        'max_length'    => '비밀번호는 30자 이하입니다'
	      ));
		$this->form_validation->set_rules('pin', 'pin', 'required|exact_length[4]', array(
	        'required'      => '핀번호를 입력해 주세요',
	        'exact_length'     	=> '핀번호의 길이는 4자리입니다'
	      ));

		$this->session->set_flashdata('email', $this->input->post('email'));

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
   		redirect($this->input->post('redirect'));
		}
		else
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$pin = $this->input->post('pin');

			$datas = array(
				'email'		 => $email,
				'password' 		 => $password,
				'pin' => $pin
			);

			$this->load->model('auth_model');
			$result = $this->auth_model->signup($datas);

			if($result == 'ok')
			{
				$arr = "<div class='alert success'>";
				$arr .= "<span class='closebtn'>&times;</span>";
				$arr .= "<span>Welcome!! Please regist your Fingerprint</span>";
				$arr .= "</div>";
				$this->session->set_flashdata('errors', $arr);
				redirect('my/fingerprint');
			}
			else if($result == 'email existed')
			{
				$this->session->set_flashdata('message', '이미 존재하는 이메일입니다.');
				redirect($this->input->post('redirect'));
			}
			else
			{
				$this->session->set_flashdata('message', '다시 시도해주세요.');
				redirect($this->input->post('redirect'));
			}
		}
	}

	public function provider_signup()
	{
		// ntbf 중복체크 메세지 버그
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
					'required'      => '이메일을 입력해 주세요',
					'valid_email'   => '이메일 형식이 잘못되었습니다'
				));
		$this->form_validation->set_rules('password', 'password', 'required|min_length[7]|max_length[30]', array(
					'required'      => '비밀번호를 입력해 주세요',
					'min_length'    => '비밀번호는 7자 이상입니다',
					'max_length'    => '비밀번호는 30자 이하입니다'
				));
		$this->form_validation->set_rules('name', 'name', 'required', array(
					'required'      => '실명를 입력해 주세요'
				));
		$this->form_validation->set_rules('phone', 'phone', 'required', array(
					'required'      => '연락가능한 전화번호를 입력해 주세요'
				));

		$this->session->set_flashdata('email', $this->input->post('email'));
		$this->session->set_flashdata('name', $this->input->post('name'));
		$this->session->set_flashdata('phone', $this->input->post('phone'));

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
			redirect($this->input->post('redirect'));
		}
		else
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$name = $this->input->post('name');
			$phone = $this->input->post('phone');

			$datas = array(
				'email'		 => $email,
				'password' 		 => $password,
				'name' 		 => $name,
				'phone' 		 => $phone
			);

			$this->load->model('auth_model');
			$result = $this->auth_model->signup_provider($datas);

			if($result == 'ok')
			{
				$arr = "<div class='alert success'>";
				$arr .= "<span class='closebtn'>&times;</span>";
				$arr .= "<span>가입을 환영합니다</span>";
				$arr .= "</div>";
				$this->session->set_flashdata('errors', $arr);
				redirect('/');
			}
			else if($result == 'email existed')
			{
				$this->session->set_flashdata('message', '이미 존재하는 이메일입니다.');
				redirect($this->input->post('redirect'));
			}
			else
			{
				$this->session->set_flashdata('message', '다시 시도해주세요.');
				redirect($this->input->post('redirect'));
			}
		}
	}

	public function unique_email($email)
	{
		$this->db->where('email', $email);
		$this->db->from('user');
		$user1 = $this->db->get()->row();

		$this->db->where('email', $email);
		$this->db->from('provider');
		$user2 = $this->db->get()->row();

		if(!$user1 && !$user2) return TRUE;
		else return FLASE;
	}


	public function signup_old()
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

	public function login()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
			'required'      => '이메일을 입력해 주세요.',
			'valid_email'   => '이메일 형식이 잘못되었습니다.'
		));

		$this->form_validation->set_rules('password', 'password', 'required|min_length[7]|max_length[30]', array(
	        'required'      => '비밀번호를 입력해 주세요',
	        'min_length'    => '비밀번호는 7자 이상입니다',
	        'max_length'    => '비밀번호는 30자 이하입니다'
    ));

		$this->form_validation->set_rules('user_type', 'user_type', 'required', array(
	        'required'      => '회원 구분을 선택해 주세요'
    ));

		$this->session->set_flashdata('email', $this->input->post('email'));

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
			redirect('login');
    }
		else
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$user_type = $this->input->post('user_type');

			$datas = array(
				'email' => $email,
				'password' => $password,
				'user_type' => $user_type
			);
			$this->load->model('auth_model');
			$result = $this->auth_model->login($datas);

			if($result == 'no email')
			{
				$this->session->set_flashdata('message', '이메일이 존재하지 않습니다.');
				redirect('login');
			}
			else if($result == 'not confirmed')
			{
				$this->session->set_flashdata('message', '이메일이 인증되지 않았습니다.');
				redirect('login');
			}
			else if($result == 'pwd wrong')
			{
				$this->session->set_flashdata('message', '비밀번호가 일치하지 않습니다.');
				redirect('login');
			}
		  else if($result == 'ok')
			{
				$returnURL = $this->input->get('returnURL');
				redirect($returnURL ? $returnURL : '/');
			}
		}
	}

	public function login_old()
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

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	}
}
