<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(['lopen']);
		$this->load->helper(['security']);
	}



	function index()
	{
		echo '<a href="mycgi?foo=', urlencode('rama'), '">test</a> | ';
		$query_string = 'foo=' . urlencode('rama') . '&bar=' . urlencode('dhian');
		echo '<a href="mycgi?' . htmlentities($query_string) . '">test2</a>';
		echo '<br>';
		echo $test = '1';
		echo '<br>';
		echo $encode = $this->lopen->encode($test);
		echo '<br>';
		echo $this->lopen->decode($encode);
	}



	function add()
	{

	}



	function edit()
	{

	}



	function remove()
	{

	}



	/*
	*	class for app
	*/
	function class_list()
	{

	}



	function class_add()
	{

	}



	function class_edit()
	{

	}



	function class_remove()
	{

	}



	/*
	*	function for class in app
	*/
	function function_list()
	{

	}



	function function_add()
	{

	}



	function function_edit()
	{

	}



	function function_remove()
	{

	}



	/*
	*	for config system
	*/
	function config_list()
	{
		if($_POST){// variabel array
			$isi = array();
			$data = array();
			$id = isset($_POST['status']) ? $_POST['status'] : 1;

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

			$where = "";
			if($search_value<>''){
				$where .= " AND (";
				foreach ($columns_name as $key => $value) if(!array_keys(array(4),$key)) {
					if($key > 0){
						$where .= "OR";
					}
					$where .= " ".$value." like '%".$search_value."%' ESCAPE '!' ";
				}
				$where .= ") ";
			}

			$jml = $this->db->query("SELECT count(config_id) as field from ms_configs where config_status=? ".$where, array($id))->row()->field;

			$where .= "ORDER BY ".$columns_name[$order_column]." ".$order_dir;
			$isi['wsearch'] = $where;
			$q = $this->db->query("SELECT * FROM `ms_configs` WHERE config_status=? ".$where." limit ?, ? ", array($id, $start, $length))->result();

			$no = 0;
			if(!empty($q)){
				$row = array();
				foreach ($q as $key) {
					$row['idhash'] = $this->lopen->encode($key->config_id);
					$row['config_id'] = $key->config_id;
					$row['config_name'] = $key->config_name;
					$row['config_value'] = $key->config_value;
					$row['config_status'] = $key->config_status;
					$row['config_desc'] = $key->config_desc;
					array_push($data, $row);
				}
			}

			$isi["draw"] = $draw;
			$isi["recordsTotal"] = $jml;
			$isi["recordsFiltered"] = $jml;
			$isi['data'] = $data;

			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($isi);
		}else{
			$data = [
				'title' => 'List Configs',
				'page' => 'vsys/config_list',
			];
			$this->load->view('blogs/mdb_blog', $data);
		}
	}



	function config_add()
	{

	}



	function config_edit()
	{
		$id = $this->lopen->decode($_GET['id']);
		$q = $this->db->get_where('ms_configs', array('config_id'=>$id))->row();
		if(!empty($q))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('config_name', 'name', 'required|max_length[150]');
			$this->form_validation->set_rules('config_value', 'value', 'required|max_length[550]');
			$this->form_validation->set_rules('config_status', 'status', 'integer|max_length[2]');
			$this->form_validation->set_rules('config_desc', 'desc', 'required|max_length[5500]');
			if($this->form_validation->run())
			{
				// echo json_encode($_POST);
				$params = $this->security->xss_clean($_POST);
				$this->db->update('ms_configs', $params, array('config_id'=>$q->config_id));
				$this->lopen->alert('updated...');
				redirect('sys/app/config_list');	
			}else{
				$data = [
					'data' => $q,
					'title' => 'edit config',
					'page' => 'vsys/config_edit',
				];
				$this->load->view('blogs/mdb_blog', $data);
			}
		}else{
			$this->lopen->alert('id not match');
			redirect('sys/app/config_list');
		}
	}



	function config_remove()
	{

	}



}