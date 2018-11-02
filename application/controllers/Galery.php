<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
// echo date_default_timezone_get();
class Galery extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->path = './src/files/';
	}



	public function index()
	{
		if($_POST){

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

			$jml = $this->db->query("SELECT count(id) as field from galery where status=? ".$where, array($id))->row()->field;

			$where .= "ORDER BY ".$columns_name[$order_column]." ".$order_dir;
			$isi['wsearch'] = $where;
			$q = $this->db->query("SELECT * FROM `galery` WHERE status=? ".$where." limit ?, ? ", array($id, $start, $length))->result();
			// end query

			// iterasi
			$no = 0;
			if(!empty($q)){
				$row = array();
				foreach ($q as $key) {
					$row['id'] = $key->id;
					$row['title'] = $key->title;
					$row['description'] = $key->description;
					$row['files'] = $key->files;
					$row['status'] = $key->status;
					$row['linkEdit'] = '<a href="'.site_url('galery/edit/?id='.$key->id).'" target="_blank">edit</a>';
					array_push($data, $row);
				}
			}
			// end iterasi

			// for datagrid
			$isi["draw"] = $draw;
			$isi["recordsTotal"] = $jml;
			$isi["recordsFiltered"] = $jml;
			$isi['data'] = $data;
			// end for datagrid

			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($isi);

		}else{
			$data['title'] = 'Galery';
			$data['page'] = 'galery/index';
			$this->load->view('blogs/mdb_blog',$data);
		}
	}



	function add()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
		$this->form_validation->set_rules('description', 'Description', 'min_length[1]');
		if($this->form_validation->run())
		{
			$params = array(
				'title' => strip_tags($this->input->post('title')),
				'description' => $this->input->post('description'),
				'files' => strip_tags(substr($this->input->post('files'), 0,-1)),
				'insert_time' => date('y-m-d H:i:s'),
				'insert_at' => $this->session->user_id,
			);
			$this->db->insert('galery', $params);

			redirect('galery');
		}else{
			$data['title'] = 'Form tambah galery';
			$data['page'] = 'galery/add';
			$this->load->view('blogs/mdb_blog',$data);
		}
	}



	function edit()
	{
		$id = $this->input->get('id');
		$data['data'] = $this->db->get_where('galery', array('id'=>$id))->row();
		if(!empty($data['data']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
			$this->form_validation->set_rules('description', 'Description', 'min_length[1]');
			$this->form_validation->set_rules('status', 'Status', 'integer|min_length[1]|max_length[1]');
			if($this->form_validation->run())
			{
				$params = array(
					'title' => strip_tags($this->input->post('title')),
					'description' => $this->input->post('description'),
					'files' => strip_tags(substr($this->input->post('files'), 0,-1)),
					'status' => strip_tags($this->input->post('status')),
					'update_time' => date('y-m-d H:i:s'),
					'update_at' => $this->session->user_id,
				);
				$this->db->update('galery', $params, array('id'=>$data['data']->id));

				redirect('galery');
			}else{
				$data['title'] = 'Form ubah galery';
				$data['page'] = 'galery/edit';
				$this->load->view('blogs/mdb_blog',$data);
			}
		}else{
			echo 'id not macth..';
		}
	}



	function delete()
	{
		$id = $this->input->get('id');
		$data['data'] = $this->db->get_where('galery', array('id'=>$id))->row();
		if(!empty($data['data']))
		{
			$this->db->update('galery', array('status'=>0), array('id'=>$data['data']->id));
			redirect('galery');
		}else{
			echo 'id not macth..';
		}
	}



}