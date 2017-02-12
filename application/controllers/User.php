<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();

      if($this->session->userdata('user_type') != 'user')
			 error_message_goto('Wrong approach 109', '/');

      $this->load->model('user_model');
	}

	public function fingerprint()
	{
		$fingerprints = $this->user_model->get_user_fingerprints($this->session->userdata('user_id'));

		$datas = array(
			'fingerprints' => $fingerprints
		);

		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('user/fingerprint_body', $datas);
		$this->load->view('home/footer');
	}

	public function regist_fingerprint()
	{
		$this->form_validation->set_rules('title', 'title', 'required|max_length[15]', array(
			'required'      => 'Title required.',
			'max_length'   => 'Title must have at least 15 characters.'
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
			redirect($this->input->post('redirect'));
		}
		else
		{
			if(!$this->session->userdata('user_id')) error_message_goto('Wrong approach 311', $this->input->post('redirect'));

			$labels = array();
			for($i = 1; $i <= 24; $i++)
			{
				$labels[] = 'fp_'.$i;
			}
			$labels[] = 'title';

			$datas = array();
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

			$datas['user_id'] = $this->session->userdata('user_id');

			$res = $this->user_model->regist_fingerprint($datas);

			if(!$res)
				error_message_goto('Try again 113', $this->input->post('redirect'));
			else
			{
				$arr = "<div class='alert success'>";
				$arr .= "<span class='closebtn'>&times;</span>";
				$arr .= "<span>Success!</span>";
				$arr .= "</div>";
				$this->session->set_flashdata('errors', $arr);
				redirect($this->input->post('redirect'));
			}
		}
	}

	public function delete_fingerprint($fp_id = 'none')
	{
		if($fp_id == 'none')
		 error_message_goto('Wrong approach 114', 'my/fingerprint');

		if(!$this->session->userdata('user_id'))
		 error_message_goto('Wrong approach 115', 'my/fingerprint');

		$datas = array(
			'user_id' => $this->session->userdata('user_id'),
			'fingerprint_id' => $fp_id
		);

		$res = $this->user_model->delete_fingerprint($datas);

		if($res == 'error' || $res == 'fail')
		 error_message_goto('Wrong approach 116', 'my/fingerprint');

		$arr = "<div class='alert success'>";
		$arr .= "<span class='closebtn'>&times;</span>";
		$arr .= "<span>Delete Success</span>";
		$arr .= "</div>";
		$this->session->set_flashdata('errors', $arr);
		redirect('my/fingerprint');
	}
}
