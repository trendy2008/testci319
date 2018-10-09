<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
// echo date_default_timezone_get();
class Grafik extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->path = './src/files/';
	}



	function index()
	{
		$data['title'] = 'Dashboard';
		$data['page'] = 'grafik/index';
		$this->load->view('design/index',$data);
	}


}