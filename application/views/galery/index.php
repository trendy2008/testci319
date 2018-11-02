
<div class="card">
	<div class="card-header font-weight-bold"><?=$title?></div>
	<div class="card-body table-responsive">

		<div class="row">
			<div class="col-6">
				<table>
					<tr>
						<td>Tampil</td>
						<td>:</td>
						<td>
					  		<select id="length" name="length" onchange="get_data()">
					  			<option value="5" selected="selected">5</option>
					  			<option value="10">10</option>
					  			<option value="25">25</option>
					  			<option value="50">50</option>
					  			<option value="100">100</option>
					  			<option value="150">150</option>
					  		</select>
				  		</td>
					</tr>
					<tr>
						<td>Galery Status</td>
						<td>:</td>
						<td>
							<select id="status" onchange="get_data()">
								<option value="0">Delete</option>
								<option value="1" selected="">Aktif</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Search</td>
						<td>:</td>
						<td>
							<input type="text" name="search" id="search" placeholder="Type search...">
						</td>
					</tr>
				</table>
			</div>
			<div class="col-6 text-right">
				<a href="<?=site_url('galery/add')?>" class="btn btn-success btn-md"><span class="fa fa-plus"></span> tambah baru</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<table id="table-datatable" class="display">
					<thead class="">
						<tr>
							<th>ID</th>
							<th>TITLE</th>
							<th>DESCRIPTION</th>
							<th>FILES ID</th>
							<th>LINK</th>
						</tr>
					</thead>
				</table>	
			</div>
		</div>

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
	    get_data();
	});

	$('#search').on('input', function(){
		get_data();
	})

	function get_data(){
		// var hsl = get_token_csrf();
		// var obj = JSON.parse(hsl);
		// alert(hsl.name+' = '+hsl.hash);
		// $('#table-datatable').DataTable().destroy();
		$('#table-datatable').DataTable({
	        "bDestroy": true,
		    "bPaginate": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bInfo": true,
		    "bAutoWidth": false,
		    "pageLength": $('#length').val(),
	        processing: true,
	        serverSide: true,
	        ajax: {
				"url": "<?=site_url('galery/index/')?>"+$('#status').val(),
				"type": "POST",
				"data": {
					// "length": $('#length').val(),
					"csrf_test_name": "<?=$this->security->get_csrf_hash()?>",
					"status": $('#status').val(),
					"search": $('#search').val(),
				}
			},
			columns: [
				{"data": "id", "orderable": false },
	            {"data": "title" },
	            {"data": "description" },
	            {"data": "files", "orderable": false },
				// {"data": "linkEdit" },
				{
					data: 'id',
					orderable: false,
					"render": function (data) {
					  return ''+
					    '<a class="" href="<?=site_url('galery/edit/?id=')?>'+data+'" title="edit data" rel="facebox"><i class="fa fa-edit"></i>edit</a> '+
					    '<a class="" href="<?=site_url('galery/edit/?id=')?>'+data+'" title="view data"><i class="fa fa-search"></i>view</a> '+
					    '<a class="" href="<?=site_url('galery/delete/?id=')?>'+data+'" title="delete data" onclick="return confirm(\'hapus data ?\')" style="color:red"><i class="fa fa-trash"></i>delete</a> '+
					    '';
					}
				}
	        ],
			fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				var index = iDisplayIndex +1;
				$('td:eq(0)',nRow).html(index);
				return nRow;
			},
	        buttons: [
	            'print',
	            // 'colvis',
        		'excel',
	        ],
	    });
	}

</script>


<link rel="stylesheet" href="<?=base_url('src/plugins/')?>facebox-master/src/facebox.css" />
<script src="<?=base_url('src/plugins/')?>facebox-master/src/facebox.js"></script>
<script type="text/javascript">
	$(function(){
		$('a[rel*=facebox]').facebox({
	        loadingImage : '<?=base_url('src/plugins/')?>facebox-master/src/loading.gif',
	        closeImage   : '<?=base_url('src/plugins/')?>facebox-master/src/closelabel.png',
	    	// width : "auto",
	    });
	});
	$(document).bind('close.facebox', function() {
	    // location.reload(true);
	    // reloadCanvas();
    });
</script>