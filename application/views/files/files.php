
<div class="card">
	<div class="card-header">
		<table>
			<tr>
				<td>Files Status</td>
				<td>:</td>
				<td>
					<select id="status" onchange="get_data(this.value)">
						<option value="0">Delete</option>
						<option value="1" selected="">Aktif</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<div class="card-body table-responsive">
		
		<table id="table-datatable" class="display table table-striped table-hover">
			<thead class="thead-dark">
				<tr>
					<th>ID</th>
					<th>FILE NAME</th>
					<th>TYPE</th>
					<th>SIZE</th>
					<!-- <th></th> -->
				</tr>
			</thead>
		</table>

	</div>
	<div class="card-footer">card footer</div>
</div>

<link href="<?=base_url()?>src/plugins/DataTables/datatables.css" rel="stylesheet" />
<script src="<?=base_url()?>src/plugins/DataTables/datatables.js"></script>
<!-- <link href="<?=base_url()?>src/plugins/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.css" rel="stylesheet" /> -->
<!-- <script src="<?=base_url()?>src/plugins/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.js"></script> -->
<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script type="text/javascript">	
    // for dataTable
    $(document).ready(function() {
	    get_data($('#status').val());
	});

	function get_data(id){
		// var hsl = get_token_csrf();
		// var obj = JSON.parse(hsl);
		// alert(hsl.name+' = '+hsl.hash);
		$('#table-datatable').DataTable().destroy();
		$('#table-datatable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: {
				"url": "<?=site_url('files/load/')?>"+id,
				"type": "POST",
				"data": {
					"csrf_test_name": "<?=$this->security->get_csrf_hash()?>",
					"status": id,
				}
			},
			columns: [
				{"data": "file_id" },
	            {"data": "client_name" },
	            {"data": "file_type" },
	            {"data": "file_size" },
	        ],
	        buttons: [
	            'print',
	            // 'colvis',
        		'excel',
	        ],
	    });
	}

</script>