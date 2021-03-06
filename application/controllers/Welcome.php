<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function __construct()
	{
		parent::__construct();
		// $this->load->helper(array('string', 'captcha'));
	}



	public function index()
	{
		$data['page'] = 'welcome_message';
		$this->load->view('design/index',$data);
	}



	public function read()
	{
		$file = ($this->input->get('var')) ? : 'readme.rst';
		$vars['title'] = 'Reading Content '.$file;
		$vars['data'] = file_get_contents($file);

		// test get data to array
		$isi = array();
		$q1 = $this->db->get_where('ms_regions', array('region_parent'=>0))->result();
		$tq1 = array();
		foreach ($q1 as $key) {
			$tq1['kode_pro'] = $key->region_id;
			$tq1['provinsi'] = $key->region;
			$tq1['isi2'] = array();

			// kabupaten
			$q2 = $this->db->get_where('ms_regions', array('region_parent'=>$key->region_id))->result();
			$tq2 = array();
			foreach ($q2 as $key2) {
				$tq2['kode_kab'] = $key2->region_id;
				$tq2['kabupaten'] = $key2->region;
				$tq2['isi3'] = array();

				// kecamatan
				$q3 = $this->db->get_where('ms_regions', array('region_parent'=>$key2->region_id))->result();
				$tq3 = array();
				foreach ($q3 as $key3) {
					$tq3['kode_kec'] = $key3->region_id;
					$tq3['kecamatan'] = $key3->region;
					$tq3['isi4'] = array();

					// kelurahan
					$q4 = $this->db->get_where('ms_regions', array('region_parent'=>$key3->region_id))->result();
					$tq4 = array();
					foreach ($q4 as $key4) {
						$tq4['kode_kel'] = $key4->region_id;
						$tq4['kelurahan'] = $key4->region;

						array_push($tq3['isi4'], $tq4);
					}

					array_push($tq2['isi3'], $tq3);
				}

				array_push($tq1['isi2'], $tq2);
			}

			array_push($isi, $tq1);
		}
		$vars['isi'] = $isi;

		// $this->load->view('blogs/read', $vars);
		$vars['page'] = 'blogs/read';
		$this->load->view('design/index',$vars);
	}



	public function captcha()
	{
		// load helper for captcha
		$this->load->helper(array('string', 'captcha'));

		// inisiasi & create captcha
		$vals = array(
			// 'image' => '<img src="'.base_url().'images/captcha/" />',
			'word' => random_string('numeric',5),	# numeric or word
			'img_path' => './src/captcha/',
			'img_url' => base_url().'src/captcha/',
			'font_path' => './src/Axettac.ttf',
			'img_width' => 140,
			'img_height' => 30,
			'expiration' => 7200,
			'word_length' => 5,
			'font_size' => 20,
	        'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 225, 0)
	        )
		);
		$cap = create_captcha($vals);
		$this->session->set_userdata('my_captcha',$cap['word']);
		
		// delete old captchas
		$expiration = time() - $vals['expiration'];
		$this->db->where('captcha_time < ', $expiration)
		        ->delete('captcha');

		// insert to table
		$data = array(
		        'captcha_time' => $cap['time'],
		        'ip_address' => $this->input->ip_address(),
		        'word' => $cap['word']
			);
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		// print source img
		print base_url().'src/captcha/'.$cap['time'].'.jpg';
	}



	public function token_csrf()
	{
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($csrf);
	}




	public function test()
	{
		$this->load->view('blogs/mdb_blog');
	}



	public function login()
	{
		$this->load->helper('form');
		if(!$_POST){
			$data['page'] = 'frm_login';
			$this->load->view('blogs/mdb_blog', $data);
		}else{
			header('Content-Type: application/json');
			echo json_encode($_POST);
		}
	}



	function form_mail()
	{
		$this->load->library('session');
		$this->load->helper('form');
		if(!$_POST){
			$data['page'] = 'frm_smail';
			$this->load->view('blogs/mdb_blog', $data);
		}else{
			// $vconf = explode('#', 'smtp#mail.akbidkartinijkt.ac.id#587#info@akbidkartinijkt.ac.id#info_12345#TRUE');
			// $vconf = explode('#', 'smtp#ssl://smtp.googlemail.com#465#kampustrendy@gmail.com#ebkaldadaltjhnou#TRUE');
			// $vconf = explode('#', 'smtp#mail.setkab.go.id#587#semnas2018@setkab.go.id#18hukum20#TRUE');
			$vconf = explode('#', 'smtp#mail.setkab.go.id#25#semnas2018@setkab.go.id#18hukum20#TRUE#tls');
			$config = array(
				'protocol' => $vconf[0],
				'smtp_host' => $vconf[1],
				'smtp_port' => $vconf[2],
				'smtp_user' => $vconf[3],
				'smtp_pass' => $vconf[4],
				// 'starttls' => $vconf[5],
				'smtp_crypto' => $vconf[6],
				'smtp_timeout' => '180',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => true,
				'newline' => "\r\n",
			);
			$this->load->library('email', $config);
			$this->email->clear(TRUE);
			$this->email->from($vconf[3], 'TESTING MAIL FROM `'.base_url().'`' );
			$this->email->to($this->input->post('to'));
			if($this->input->post('cc')<>''){
				$this->email->cc($this->input->post('cc'));
			}
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message'));
			if(!empty($this->input->post('attach'))){
				foreach($this->input->post('attach') as $key) {
					$this->email->attach($key);
				}
			}
			$sndmail = $this->email->send();
			
			$dbg = $this->email->print_debugger();

			if($sndmail){
				$msg = json_encode(array('status'=>true, 'msg'=>'berhasil mengirim email ke '.$this->input->post('to')));
			}else{
				$msg = json_encode(array('status'=>false, 'msg'=>'gagal mengirim email ke '.$this->input->post('to')));
			}

			$this->session->set_flashdata('fmsg', $msg.'; '.$dbg);
			redirect('welcome/form_mail');
			// header('Content-Type: application/json');
			// echo json_encode($_POST);
		}
	}


	public function search_instansi()
	{
		$where = "";
		$val = $this->db->escape_like_str($this->input->get('val'));
		if($val<>''){
			$where .= "where inskerja like '%".$val."%' ";
		}
		$q = $this->db->query("SELECT inskerja from emeeting.conf_user_eks ".$where." group by inskerja limit 10 ")->result();
		$arr = array();
		foreach ($q as $key) {
			array_push($arr, $key->inskerja);
		}
		// header('Content-type: application/json');
		echo json_encode($arr);
	}


}
