


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
						<td>Status</td>
						<td>:</td>
						<td>
							<select id="status" onchange="get_data()">
								<option value="0">Non Aktif</option>
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
							<th>NAME</th>
							<th>VALUE</th>
							<th>STATUS</th>
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
<script type="text/javascript">	
    // for dataTable
    $(document).ready(function() {
	    get_data();
	});

	$('#search').on('input', function(){
		get_data();
	})

	function get_data(){
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
				"url": "<?=site_url('sys/app/config_list/')?>",
				"type": "POST",
				"data": {
					"csrf_test_name": "<?=$this->security->get_csrf_hash()?>",
					"status": $('#status').val(),
					"search": $('#search').val(),
				}
			},
			columns: [
				{"data": "config_id", "orderable": true },
	            {"data": "config_name" },
	            {
	            	"data": "config_desc",
	            	"render": function(data){
	            		return data;
	            	}
	            },
	            {
	            	"data": "config_status", 
	            	"orderable": false,
	            	"render": function(data){
	            		if(data==0){
	            			return 'Non Aktif';
	            		}else if(data==1){
	            			return 'Aktif';
	            		}else{
	            			return '';
	            		}
	            	}
	            },
				{
					data: 'idhash',
					orderable: false,
					"render": function (data) {
					  return ''+
					    '<a class="" href="<?=site_url('sys/app/config_edit/?id=')?>'+data+'" title="edit data" rel="facebox"><i class="fa fa-edit"></i> </a> '+
					    '<a class="" href="<?=site_url('sys/app/config_edit/?id=')?>'+data+'" title="view data"><i class="fa fa-search"></i> </a> '+
					    '<a class="" href="<?=site_url('sys/app/config_remove/?id=')?>'+data+'" title="delete data" onclick="return confirm(\'hapus data ?\')" style="color:red"><i class="fa fa-trash"></i> </a> '+
					    '';
					}
				}
	        ],
			fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				var index = iDisplayIndex +1;
				$('td:eq(0)',nRow).html(index);
				return nRow;
			},
	    });
	}

</script>