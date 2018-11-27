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
		$data = [
			'title' => 'Index Files class',
			'page' => 'files/files',
		];
		$this->load->view('blogs/mdb_blog',$data);
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

		    header('Content-Type: application/json; charset=UTF-8');
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
		    	// 'reff' => ($this->input->get('id'))?:'',
		    ));
		    // end insert to db
		    $data['id_file'] = $this->db->insert_id();

		    header('Content-Type: application/json; charset=UTF-8');
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



    public function load($id=1)
    {
    	/*
		$ret = array();
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
		echo json_encode($ret);
		*/

		// variabel array
		$isi = array();
		$data = array();
		$id = isset($_POST['status']) ? $_POST['status'] : 1;

		// datatable variable
		$start = (int) (($this->db->escape_str($_POST['start'])) ? : 0);
		$draw = (int) (($this->db->escape_str($_POST['draw'])) ? : 1);
		$length = (int) (($this->db->escape_str($_POST['length'])) ? : 10);
		$order_column = (int) (($this->db->escape_str($_POST['order'][0]['column'])) ? : 0);
		$order_dir = ($this->db->escape_str($_POST['order'][0]['dir'])) ? : 'asc';
		$columns_name = array();
		for ($i=0; $i < count($_POST['columns']); $i++) { 
			array_push($columns_name, $this->db->escape_str($_POST['columns'][$i]['data']));
		}
		$search_value = $this->db->escape_str($_POST['search']/*['value']*/);
		// end datatable variable

		// query
		$where = "";
		if($search_value<>''){
			$where .= " AND (";
			foreach ($columns_name as $key => $value) {
				if($key > 0){
					$where .= "OR";
				}
				$where .= " ".$value." like '%".$search_value."%' ESCAPE '!' ";
			}
			$where .= ") ";
		}
		$jml = $this->db->query("SELECT count(file_id) as field from files where status=? ".$where, array($id))->row()->field;
		$where .= "ORDER BY ".$columns_name[$order_column]." ".$order_dir;
		$isi['wsearch'] = $where;
		$q = $this->db->query("SELECT * FROM `files` WHERE status=? ".$where." limit ?, ? ", array($id, $start, $length))->result();
		// end query

		// query builder
		/*$this->db->where('status', $id);
		if($search_value<>''){
			foreach ($columns_name as $key => $value) {
				if($key>0){
					$this->db->or_like($value, $search_value);
				}else{
					$this->db->like($value, $search_value);
				}
			}
		}
		$this->db->order_by($columns_name[$order_column], $order_dir);
		$this->db->limit($length, $start);
		$q = $this->db->get('files')->result();*/
		// end query builder

		// iterasi
		$no = 0;
		if(!empty($q)){
			$row = array();
			foreach ($q as $key) {
				/*$data["link"] = '
			      	[<a href="'.site_url('files/download/?filename='.$key->file_name).'" target="_blank">download</a>]
			      	[<a href="'.site_url('files/delete/?filename='.$key->file_name).'" onclick="return confirm(\'delete file?\')" target="_blank">delete</a>]
			    ';*/
				array_push($data, $key);
			}
		}
		// $record_view = $this->db->affected_rows();
		// $jml = $this->db->count_all('files');
		// end iterasi

		// for datagrid
		$isi["draw"] = $draw;
		$isi["recordsTotal"] = $jml;
		$isi["recordsFiltered"] = $jml;
		$isi['data'] = $data;
		// end for datagrid

		/*$isi["draw"] = $draw;
		$isi["length"] = $length;
		$isi["rows"] = $data;
		$isi["total"] = $jml;*/

		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($isi);
	}





	/*
	*	for notifikasi
	*/
	// function cek_for_send()
	// {
	// 	$q = $this->db->query("SELECT * FROM rapat_notulen_tindaklanjut 
	// 		where  tndk_emailsend < 3 
	// 		and tndk_status > 0 and tndk_status < 4
	// 		and DATEDIFF(tndk_batasakhir, '".date('Y-m-d')."') <= 3
	// 		")->result();
	// 	if(!empty($q)){
	// 		// echo json_encode($q);
	// 		foreach ($q as $key) {
	// 			// $this->kirim_email_notifikasi($key->rapat_id, $key->id_pegawai);
	// 			$this->kirim_email_notifikasi($key->rapat_id, $key->tndk_id);
	// 		}
	// 	}

	// 	$q = $this->db->query("SELECT * FROM rapat_notulen_tindaklanjut 
	// 		where  tndk_emailsend < 4
	// 		and tndk_status > 0 and tndk_status < 4
	// 		and DATEDIFF(tndk_batasakhir, '".date('Y-m-d')."') <= 1
	// 		")->result();
	// 	if(!empty($q)){
	// 		// echo json_encode($q);
	// 		foreach ($q as $key) {
	// 			// $this->kirim_email_notifikasi($key->rapat_id, $key->id_pegawai);
	// 			$this->kirim_email_notifikasi($key->rapat_id, $key->tndk_id);
	// 		}
	// 	}
	// }


}