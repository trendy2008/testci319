<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
// echo date_default_timezone_get();
class Files extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->path = './src/files/';
	}



	public function index()
	{
		$data['title'] = 'Index Files class';
		$data['page'] = 'file';
		$this->load->view('templates/eNno/blog',$data);
	}



    public function upload()
    {
		$config['upload_path'] = $this->path;	#'./uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|txt|pdf|ppt|pptx|xls|xlsx';
		// $config['file_name'] = '';
		$config['file_ext_tolower'] = FALSE;
		$config['overwrite'] = FALSE;
		// $config['max_size'] = 2000;
		// $config['max_width'] = 1024;
		// $config['max_height'] = 768;
		// $config['min_width'] = 0;
		// $config['min_height'] = 0;
		// $config['max_filename'] = 0;
		// $config['max_filename_increment'] = 100;
		$config['encrypt_name'] = TRUE;	#false
		$config['remove_spaces'] = TRUE;
		$config['detect_mime'] = TRUE;
		$config['mod_mime_fix'] = TRUE;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile'))
		{
		    $data = array('error' => $this->upload->display_errors());
		    $data['csrf'] = $this->security->get_csrf_hash();
		    echo json_encode($data);
		}else{
		    $data = array('upload_data' => $this->upload->data());
		    $data['csrf'] = $this->security->get_csrf_hash();
		    // insert to db
		    $this->db->insert('files', array(
		    	'file_name' => $data['upload_data']['file_name'],
		    	'file_type' => $data['upload_data']['file_type'],
		    	'file_path' => $data['upload_data']['full_path'],
		    	'file_ext' => $data['upload_data']['file_ext'],
		    	'file_size' => $data['upload_data']['file_size'],
		    	'client_name' => $data['upload_data']['client_name'],
		    	'user_upload' => $this->session->user_id,
		    	'reff' => ($this->input->get('id'))?:'',
		    ));
		    // end insert to db
		    $data['id_file'] = $this->db->insert_id();
		    echo json_encode($data);
		}
    }



    public function download()
    {
		if(isset($_GET['filename']))
		{
			$fileName = $_GET['filename'];
			$fileName = str_replace("..", ".", $fileName);
			$file = $this->path . $fileName;
			$file = str_replace("..", "", $file);
			if (file_exists($file)) {
				$fileName = str_replace(" ", "", $fileName);
			    header('Content-Description: File Transfer');
			    header('Content-Disposition: attachment; filename='.$fileName);
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    ob_clean();
			    flush();
			    readfile($file);
			    exit;
			}else{
				print('<h1 style="color:red; margin: 20px" align="center">Maaf, file tidak ditemukan...</h1>');
			}
		}else{
			show_error('tidak ada variable yang dilempar');
		}
    }



    public function delete()
    {
		$output_dir = $this->path;
		if(isset($_GET['filename']) && $_GET['filename']<>'')
		{
			$fileName = $_GET['filename'];
			$fileName = str_replace("..", ".", $fileName);
			$filePath = $output_dir . $fileName;
			if (file_exists($filePath)) 
			{
				// update db
				$this->db->update('files', array(
						'status' => 0, 
						'time_delete' => date('y-m-d H:i:s'),
						'user_delete' => $this->session->user_id,
					), 
					array('file_name' => $fileName)
				);
				// end update db
		        unlink($filePath);
		        echo 'delete file '.$fileName;
		    }
		    else
				echo "File ".$fileName." not found";
		}else{
			show_error('tidak ada variable yang dilempar');
		}
    }



    public function load($id='')
    {
		$ret = array();
		/*
		$dir = $this->path;
		$files = scandir($dir);
		foreach($files as $file)
		{
			if($file == "." || $file == "..")
				continue;
			$filePath = $dir . $file;
			$details = array();
			$details['name'] = $file;
			$details['path'] = $filePath;
			$details['size'] = filesize($filePath);
			$details['type'] = filetype($filePath);
			$details['link_download'] = '<a href="'.site_url('files/download/?filename='.$file).'">'.$file.'</a>';
			$details['link_delete'] = '<a href="'.site_url('files/delete/?filename='.$file).'">'.$file.'</a>';
			if(filetype($filePath)=='dir'){
				$dir2 = $filePath.'/';
				$files2 = scandir($dir2);
				$ret2 = array();
				foreach ($files2 as $file2) {
					if($file2 =='.' || $file2=='..')
						continue;
					$filePath2 = $dir2 . $file2;
					$details2 = array();
					$details2['name'] = $file2;
					$details2['path'] = $filePath2;
					$details2['size'] = filesize($filePath2);
					$details2['type'] = filetype($filePath2);
					# code...
					$ret2[] = $details2;
				}
				$details['isi'] = $ret2;
			}
			$ret[] = $details;
		}
		// echo json_encode($ret);
		print_r($ret);
		*/
		$isi = array();
		$data = array();
		$isi["draw"] = 1;
		$no = 0;
		$q = $this->db->get_where('files', array('status'=>$id))->result();
		if(!empty($q)){
			$row = array();
			foreach ($q as $key) {
				array_push($data, $key);
				/*echo'
			      	[<a href="'.site_url('files/download/?filename='.$key->file_name).'" target="_blank">download</a>]
			      	[<a href="'.site_url('files/delete/?filename='.$key->file_name).'" onclick="return confirm(\'delete file?\')" target="_blank">delete</a>]
			    ';*/
			}
		}
		$jml = $this->db->affected_rows();
		$isi["recordsTotal"] = $jml;
		$isi["recordsFiltered"] = $jml;
		$isi['data'] = $data;

		echo json_encode($isi);
	}





	/*
	*	for notifikasi
	*/
	function cek_for_send()
	{
		$q = $this->db->query("SELECT * FROM rapat_notulen_tindaklanjut 
			where  tndk_emailsend < 3 
			and tndk_status > 0 and tndk_status < 4
			and DATEDIFF(tndk_batasakhir, '".date('Y-m-d')."') <= 3
			")->result();
		if(!empty($q)){
			// echo json_encode($q);
			foreach ($q as $key) {
				// $this->kirim_email_notifikasi($key->rapat_id, $key->id_pegawai);
				$this->kirim_email_notifikasi($key->rapat_id, $key->tndk_id);
			}
		}

		$q = $this->db->query("SELECT * FROM rapat_notulen_tindaklanjut 
			where  tndk_emailsend < 4
			and tndk_status > 0 and tndk_status < 4
			and DATEDIFF(tndk_batasakhir, '".date('Y-m-d')."') <= 1
			")->result();
		if(!empty($q)){
			// echo json_encode($q);
			foreach ($q as $key) {
				// $this->kirim_email_notifikasi($key->rapat_id, $key->id_pegawai);
				$this->kirim_email_notifikasi($key->rapat_id, $key->tndk_id);
			}
		}
	}

    function kirim_email_notifikasi($rapat='', $idpeg='')
    {
    	$data['data'] = $this->open->get_rapat($rapat);
    	if(!empty($data['data'])){
    		// echo json_encode($data['data']);
    		// $to = array();
    		$to = '';
    		$cc = array();
    		$pstndk = $this->open->daftar_pegawai_tindaklanjut_getdata_id($idpeg);
	        $tempat = ''.$data['data']->ruang_nama.', '.$data['data']->area_name.', Lt. '.$data['data']->ruang_lantai.', '.$data['data']->ruang_alamat;
	        $file = array();
	        $emails = '';

	        #Email kastaf & staf khusus
	        $qr = $this->db->query("SELECT * FROM spd_pegawai where status=? and jabatan in ? ", array(1,array(10,35)))->result();	#10=kastaf, 35=staf khusus
	        if(!empty($qr)){
	        	foreach ($qr as $key) {
	        		if(array_keys(array(10,35),$key->jabatan)) {
	        			array_push($cc, $key->email2);
	        		}
	        	}
	        }
	        #Email sespri
			foreach ($this->open->create_array($this->open->get_val_param('sespri'),',') as $key => $value) {
				array_push($cc, $value);
			}

    		if(!empty($pstndk)){
    			foreach ($pstndk as $key) {
    				// array_push($to, $key->email);
    				$to = $key->email;
					$qtemp = $this->db->get_where('template_mail', array('template_status'=>1, 'template_id'=>11))->row();
					if(!empty($qtemp)){
						$body_message = str_replace(
							array(
								'{nama_rapat}', '{waktu}', '{tempat}', '{namaps}', '{tanggalps}', '{tindaklanjutps}'
							), 
							array(
								$data['data']->rapat_nama, $this->open->tanggal($data['data']->rapat_tgl1, 6).' '.$data['data']->rapat_jam1.' s/d selesai', $tempat, $key->name.' ( '.$key->jabatan.' | '.$key->inskerja.' )', $key->tndk_batasakhir, $key->tndk_tugas
							), 
							$qtemp->template_content
						);
					}
					
		        	// echo json_encode($almt);
		        	if($key->tndk_emailsend<3){
			        	$almt = array(
			        		'to' => $to,
			        		// 'cc' => $cc,
			        		'subject' => 'Notifikasi Tindak Lanjut Rapim yang harus segera diselesaikan',
			        		'message' => $body_message,
			        		'attach' => $file,
			        	);
			        	// $rtn = $this->open->send_mail($almt);
			        	// if($rtn){
			        	// 	$emails .= $key->email.', ';
			        	// }
			        	// $this->db->update('rapat_notulen_tindaklanjut', array('tndk_emailsend'=>3), array('tndk_id'=>$key->tndk_id));
			        }elseif($key->tndk_emailsend==3 && $key->tndk_emailsend<4){
			        	$almt = array(
			        		'to' => $to,
			        		'cc' => $cc,
			        		'subject' => 'Notifikasi Tindak Lanjut Rapim yang harus segera diselesaikan',
			        		'message' => $body_message,
			        		'attach' => $file,
			        	);
			        	// $rtn = $this->open->send_mail($almt);
			        	// if($rtn){
			        	// 	$emails .= $key->email.', ';
			        	// }
			        	// $this->db->update('rapat_notulen_tindaklanjut', array('tndk_emailsend'=>4), array('tndk_id'=>$key->tndk_id));
			        }
		        }
		        echo $emails;
	        }
    	}
    }



    function pimpinan()
    {
    	if($_POST)
    	{
    		$rpt = $this->input->post('id_rpt');
    		$psr = $this->input->post('id_psr');
    		$this->db->update('rapat_peserta', array('pimpinan'=>1), array('peserta_id'=>$psr));
    		// $this->db->update('rapat_notulen_tindaklanjut', array('pimpinan'=>0), array('peserta_id'=>$this->input->post('id_psr'))));
			$this->db->query("UPDATE `rapat_peserta` SET `pimpinan`=0 where rapat_id=? and peserta_id not in (?)  ", array($rpt, array($psr)));
    	}
    }



}