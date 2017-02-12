<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();

      if($this->session->userdata('user_type') != 'provider')
      {
        $this->session->set_flashdata('message', 'Wrong approach 440');
        redirect('/');
      }
      $this->load->model('provider_model');
	}

	public function my_site()
	{
		$my_sites = $this->provider_model->get_provider_site($this->session->userdata('user_id'));

		if($my_sites == 'no provider')
		{
			$this->session->set_flashdata('message', 'Wrong approach 441');
			redirect('/');
		}

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

		}
		else
		{
			$res = $this->provider_model->is_right_provider($this->session->userdata('user_id'), $app_id);
			if( ! $res)
			{
				$this->session->set_flashdata('message', 'Wrong approach 442');
				redirect('/');
			}
			$datas['what'] = $res;
		}

		$this->load->view('home/head');
		$this->load->view('home/nav');
		$this->load->view('provider/regist_body', $datas);
		$this->load->view('home/footer');

	}

	public function regist_submit()
	{

	}
}
