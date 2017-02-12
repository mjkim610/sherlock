<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();

      if($this->session->userdata('user_type') != 'provider')
			 error_message_goto('Wrong approach 440', '/');

			$this->load->model('provider_model');
	}

	public function my_site()
	{
		$my_sites = $this->provider_model->get_provider_site($this->session->userdata('user_id'));

		if($my_sites == 'no provider')
		 error_message_goto('Wrong approach 441', '/');

		$datas = array(
			'my_sites' => $my_sites
		);

		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('provider/my_site_body', $datas);
		$this->load->view('home/footer');
	}

	public function regist($app_id = 'none')
	{
		// app_id 가 없으면 새로 생성, 있으면 수정 (form에 value로)
		//

		$datas = array();

		if($app_id == 'none')
		{
			$datas['state'] = 'regist';
		}
		else
		{
			$res = $this->provider_model->is_right_provider($this->session->userdata('user_id'), $app_id);
			if( ! $res)
			 error_message_goto('Wrong approach 442', '/');

			$datas['state'] = 'edit';
			$datas['service'] = $res;
		}

		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('provider/regist_body', $datas);
		$this->load->view('home/footer');

	}

	public function regist_submit()
	{
		if($this->input->post('state') != 'regist' && $this->input->post('state') != 'edit')
			error_message_goto('Wrong approach 444', $this->input->post('redirest'));

		if($this->input->post('state') == 'regist')
		{
			$this->form_validation->set_rules('service_name', 'service_name', 'required|min_length[1]|max_length[20]|is_unique[service.service_name]', array(
						'required'      => 'Service name required',
						'min_length'      => 'Service name must have at least 1 characters',
						'max_length'      => 'Service name must have at most 20 characters',
						'is_unique'      => 'Service name already exists'
					));
		}
		$this->form_validation->set_rules('description', 'description', 'required|min_length[5]|max_length[150]', array(
					'required'      => 'Description required',
					'min_length'      => 'Description must have at least 5 characters',
					'max_length'      => 'Description must have at most 150 characters'
				));
		$this->form_validation->set_rules('url', 'url', 'required', array(
					'required'      => 'URL required'
				));
		$this->form_validation->set_rules('redirect_url', 'redirect_url', 'required', array(
					'required'      => 'Redirect URL required'
				));
		$this->form_validation->set_rules('threshold_1', 'threshold_1', 'required|less_than_equal_to[100]', array(
					'required'      => 'Threshold 1 required',
					'less_than_equal_to'      => 'Threshold 1 must be less than equal to 100'
				));
		$this->form_validation->set_rules('threshold_2', 'threshold_2', 'required|less_than_equal_to[100]', array(
					'required'      => 'Threshold 2 required',
					'less_than_equal_to'      => 'Threshold 2 must be less than equal to 100'
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

		$datas = array();

		if($this->input->post('state') == 'regist')
		{
			$datas['service_name'] = $this->input->post('service_name');
		}
		$datas['description'] = $this->input->post('description');
		$datas['url'] = $this->input->post('url');
		$datas['redirect_url'] = $this->input->post('redirect_url');
		$datas['threshold_1'] = $this->input->post('threshold_1');
		$datas['threshold_2'] = $this->input->post('threshold_2');

		if( ! is_numeric($datas['threshold_1']) || ! is_numeric($datas['threshold_2']) )
			error_message_goto('Threshold must be numeric (0~100)', $this->input->post('redirect'));

		if($datas['threshold_1'] <= $datas['threshold_2'])
			error_message_goto('Threshold 1 must be bigger than Threshold 2', $this->input->post('redirect'));

		$extra = array();
		$extra['provider_id'] = $this->session->userdata('user_id');
		$extra['state'] = $this->input->post('state');

		if($this->input->post('state') == 'edit')
		{
			$extra['app_id'] = $this->input->post('app_id');
		}

		$new_datas = array('datas' => $datas, 'extra' => $extra);
		$res = $this->provider_model->set_service($new_datas);

		if($res)
		{
			$arr = "<div class='alert success'>";
			$arr .= "<span class='closebtn'>&times;</span>";
			$arr .= "<span>Success! We'll send you email after we check your site</span>";
			$arr .= "</div>";

			$this->session->set_flashdata('errors', $arr);
			redirect('my/site');
		}

		var_dump($datas);


	}
}
