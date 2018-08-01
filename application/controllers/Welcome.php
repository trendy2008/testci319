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
		$this->load->view('welcome_message');
	}



	public function read()
	{
		$file = ($this->input->get('var')) ? : 'readme.rst';
		$vars['title'] = 'Reading Content '.$file;
		$vars['data'] = file_get_contents($file);

		// test get data to array
		$isi = array();
		$q1 = $this->db->get('reff_provinsi')->result();
		$tq1 = array();
		foreach ($q1 as $key) {
			$tq1['kode_pro'] = $key->id;
			$tq1['provinsi'] = $key->name;
			$tq1['isi2'] = array();

			// kabupaten
			$q2 = $this->db->get_where('reff_kabupaten', array('province_id'=>$key->id))->result();
			$tq2 = array();
			foreach ($q2 as $key2) {
				$tq2['kode_kab'] = $key2->id;
				$tq2['kabupaten'] = $key2->name;
				$tq2['isi3'] = array();

				// kecamatan
				$q3 = $this->db->get_where('reff_kecamatan', array('regency_id'=>$key2->id))->result();
				$tq3 = array();
				foreach ($q3 as $key3) {
					$tq3['kode_kec'] = $key3->id;
					$tq3['kecamatan'] = $key3->name;
					$tq3['isi4'] = array();

					// kelurahan
					$q4 = $this->db->get_where('reff_kelurahan', array('district_id'=>$key3->id))->result();
					$tq4 = array();
					foreach ($q4 as $key4) {
						$tq4['kode_kel'] = $key4->id;
						$tq4['kelurahan'] = $key4->name;

						array_push($tq3['isi4'], $tq4);
					}

					array_push($tq2['isi3'], $tq3);
				}

				array_push($tq1['isi2'], $tq2);
			}

			array_push($isi, $tq1);
		}
		$vars['isi'] = $isi;

		$this->load->view('blogs/read', $vars);
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
			'expiration' => 50,	#7200,
			'word_length' => 8,
			'font_size' => 18,
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


}