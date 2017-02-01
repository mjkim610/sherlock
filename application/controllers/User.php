<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();

      if($this->session->userdata('user_type') != 'user')
      {
        $this->session->set_flashdata('message', 'wrong approach');
        redirect('/');
      }
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
			'required'      => '설명을 입력해 주세요.',
			'max_length'   => '설명은 최대 15자까지 가능합니다.'
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
			if(!$this->session->userdata('user_id'))
			{
				$this->session->set_flashdata('message', '잘못된 접근입니다');
				redirect($this->input->post('redirect'));
			}

			// post 받을 준비
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
			$datas['user_id'] = $this->session->userdata('user_id');

			// ntbf IP 받아오기

			$res = $this->user_model->regist_fingerprint($datas);
			if(!$res)
			{
				$this->session->set_flashdata('message', '다시 시도해주세요');
			}
			else
			{
				$arr = "<div class='alert success'>";
				$arr .= "<span class='closebtn'>&times;</span>";
				$arr .= "<span>등록 완료!</span>";
				$arr .= "</div>";
				$this->session->set_flashdata('errors', $arr);
			}
			redirect($this->input->post('redirect'));
		}
	}

	public function delete_fingerprint($fp_id = 'none')
	{
		if($fp_id == 'none')
		{
			$this->session->set_flashdata('message', 'wrong approach1');
			redirect('my/fingerprint');
		}

		if(!$this->session->userdata('user_id'))
		{
			$this->session->set_flashdata('message', 'wrong approach2');
			redirect('my/fingerprint');
		}

		$datas = array(
			'user_id' => $this->session->userdata('user_id'),
			'fingerprint_id' => $fp_id
		);

		$res = $this->user_model->delete_fingerprint($datas);

		if($res == 'error' || $res == 'fail')
		{
			$this->session->set_flashdata('message', 'wrong approach3');
			redirect('my/fingerprint');
		}

		$arr = "<div class='alert success'>";
		$arr .= "<span class='closebtn'>&times;</span>";
		$arr .= "<span>Delete Success</span>";
		$arr .= "</div>";
		$this->session->set_flashdata('errors', $arr);
		redirect('my/fingerprint');

	}
}
