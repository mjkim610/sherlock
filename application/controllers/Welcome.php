<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

	public function hell()
	{
		$email = $this->input->post('email');
		$datas = $this->input->post('datas');

		$datas_string = json_decode($datas); // $datas_string = array(23) { [0]=> string(73) "Mozilla/5.0 ~~
		var_dump($datas_string);
		// echo 'hello!';
	}
}
