<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('auth_model');
	}

	// 일반회원 회원가입
	public function signup()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
	        'required'      => 'Email required',
	        'valid_email'   => 'Email is not valid'
	      ));
		$this->form_validation->set_rules('password', 'password', 'required|min_length[7]|max_length[30]', array(
	        'required'      => 'Password required',
	        'min_length'    => 'Password must have at least 7 characters',
	        'max_length'    => 'Password must have at most 30 characters'
	      ));
		$this->form_validation->set_rules('pin', 'pin', 'required|exact_length[4]', array(
	        'required'      => 'PIN number required',
	        'exact_length'     	=> 'PIN number must have 4 digit'
	      ));

		// 다시 쓰기 귀찮으니까
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

			// 회원가입 실행
			$result = $this->auth_model->signup($datas);

			if($result == 'ok') // 회원가입 성공
			{
				$arr = "<div class='alert success'>";
				$arr .= "<span class='closebtn'>&times;</span>";
				$arr .= "<span>Welcome!! Please register your Fingerprint</span>";
				$arr .= "</div>";
				$this->session->set_flashdata('errors', $arr);
				redirect('my/fingerprint');
			}
			else if($result == 'email existed') // 이메일 중복
			{
				$this->session->set_flashdata('message', 'Email already exists.');
				redirect($this->input->post('redirect'));
			}
			else // 기타 에러
			{
				$this->session->set_flashdata('message', 'Try again');
				redirect($this->input->post('redirect'));
			}
		}
	}

	// 서비스 관리자 회원가입
	public function provider_signup()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
	        'required'      => 'Email required',
	        'valid_email'   => 'Email is not valid'
	      ));
		$this->form_validation->set_rules('password', 'password', 'required|min_length[7]|max_length[30]', array(
	        'required'      => 'Password required',
	        'min_length'    => 'Password must have at least 7 characters',
	        'max_length'    => 'Password must have at most 30 characters'
	      ));
		$this->form_validation->set_rules('name', 'name', 'required', array(
					'required'      => 'Name required'
				));
		$this->form_validation->set_rules('phone', 'phone', 'required', array(
					'required'      => 'Phone number required'
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

	// 로그인
	public function login()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email', array(
	        'required'      => 'Email required',
	        'valid_email'   => 'Email is not valid'
	      ));
		$this->form_validation->set_rules('password', 'password', 'required|min_length[7]|max_length[30]', array(
	        'required'      => 'Password required',
	        'min_length'    => 'Password must have at least 7 characters',
	        'max_length'    => 'Password must have at most 30 characters'
	      ));
		$this->form_validation->set_rules('user_type', 'user_type', 'required', array(
	        'required'      => 'User type required'
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

			$result = $this->auth_model->login($datas);

			if($result == 'no email')
			{
				$this->session->set_flashdata('message', 'Email does not exist.');
				redirect('login');
			}
			else if($result == 'pwd wrong')
			{
				$this->session->set_flashdata('message', 'Password wrong.');
				redirect('login');
			}
		  else if($result == 'ok')
			{
				$returnURL = $this->input->get('returnURL');
				redirect($returnURL ? $returnURL : '/');
			}
		}
	}

	// 이메일 중복검사
	public function unique_email($email)
	{
		$this->db->where('email', $email);
		$this->db->from('user');
		$user1 = $this->db->get()->row();

		$this->db->where('email', $email);
		$this->db->from('provider');
		$user2 = $this->db->get()->row();

		// 어느쪽에도 없어야 true
		if(!$user1 && !$user2) return TRUE;
		else return FLASE;
	}

	// 로그아웃
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	}
}
