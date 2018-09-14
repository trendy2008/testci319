
<div class="container" style="margin-top: 20px">
	<div class="panel panel-primary">
		<div class="panel-body">
			
			<table id="grid-data-api" class="">
				<thead>
					<tr>
						<th data-column-id="file_id">ID</th>
						<th data-column-id="file_name">FILE NAME</th>
						<th data-column-id="file_type">TYPE</th>
						<th data-column-id="file_size">SIZE</th>
						<!-- <th data-column-id="file_ext"></th> -->
					</tr>
				</thead>
			</table>

		</div>
	</div>
	<button onclick="load()">TEST</button>
	<div id="dtest"></div>	
</div>

<script type="text/javascript" src="<?=base_url()?>src/js/jquery-3.3.1.min.js"></script>
<!-- <script src="<?=base_url()?>src/jquery-bootgrid-master/lib/jquery-1.11.1.min.js"></script> -->

<link href="<?=base_url()?>src/jquery-bootgrid-master/demo/css/bootstrap.css" rel="stylesheet" />
<script src="<?=base_url()?>src/jquery-bootgrid-master/demo/js/bootstrap.js"></script>
<!-- <script src="<?=base_url()?>src/jquery-bootgrid-master/demo/js/moderniz.2.8.1.js"></script> -->

<!-- <link href="<?=base_url()?>src/jquery-bootgrid-master/dist/jquery.bootgrid.css" rel="stylesheet" /> -->
<!-- <script src="<?=base_url()?>src/jquery-bootgrid-master/dist/jquery.bootgrid.js"></script> -->
<!-- <script src="<?=base_url()?>src/jquery-bootgrid-master/dist/jquery.bootgrid.fa.js"></script> -->

<link href="<?=base_url()?>src/DataTables/datatables.css" rel="stylesheet" />
<script src="<?=base_url()?>src/DataTables/datatables.js"></script>

<script type="text/javascript">	

    /*var grid = $("#grid-data-api").bootgrid({
        ajax: true,
        url: "<?=site_url('files/load/')?>",
        // post: function ()
        // {
        //     return {
        //         id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        //     };
        // },
        formatters: {
            "commands": function(column, row)
            {
                return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.file_id + "\"><span class=\"fa fa-pencil\"></span></button> " + 
                    "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.file_id + "\"><span class=\"fa fa-trash-o\"></span></button>";
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function(){
        grid.find(".command-edit").on("click", function(e){
            alert("You pressed edit on row: " + $(this).data("row-id"));
        }).end().find(".command-delete").on("click", function(e){
            alert("You pressed delete on row: " + $(this).data("row-id"));
        });
    });*/


    // for dataTable
    $(document).ready(function() {
	    $('#grid-data-api').DataTable( {
	        "processing": true,
	        "serverSide": true,
	        "ajax": {
				"url": "<?=site_url('files/load/')?>",
				"type": "POST",
				"data": {
					"token":"<?=$this->security->get_csrf_hash()?>",
				}
			},
			"columns": [
				{"data": "file_id"},
	            {"data": "file_name" },
	            {"data": "file_type" },
	            {"data": "file_size" },
	        ]
	    });
	});

</script>