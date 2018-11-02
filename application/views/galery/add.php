

<div class="card">
	<div class="card-header font-weight-bold"><?=$title?></div>
	<div class="card-body">
	
		<?=form_open('', array('class'=>'form'))?>
		<div class="row">
			<div class="col-8">
			
				<b>Title:</b>
				<input type="text" name="title" value="<?=$this->input->post('title')?>" required="required" class="form-control" placeholder="title....">
				<?=form_error('title')?>

				<br>
				<b>Description:</b>
				<textarea name="description" required="required" class="form-control textEditor" placeholder="description..."></textarea>
				<?=form_error('description')?>

				<b>Select File:</b>
				<input type="file" name="file_select" id="file_select" class="">
				<input type="hidden" name="files" id="files" value="<?=$this->input->post('files')?>">

				<hr>
				<button type="submit" style="" class="btn btn-primary btn-md">Simpan</button>
				<button type="reset" style="" class="btn btn-primary btn-md" onclick="window.location.assign('<?=site_url('galery')?>')">Batal</button>

			</div>
			<div class="col-4">

				<b>Files Upload:</b>
				<div id="file_list" class="row"></div>
				
			</div>
		</div>
		<?=form_close()?>

	</div>
</div>

<!-- style -->
<style type="text/css">
	td{
		padding: 3px;
		vertical-align: top;

	}
</style>

<?php 
// for form upload
echo form_open_multipart('files/upload/?id=', array('id'=>'formupload'));
echo form_close();
?>
<script type="text/javascript">
	$('#file_select').on('change', function(){
		var tmp_files = $('#files').val();
		var formData = new FormData();
		formData.append('userfile', $('input[type=file]')[0].files[0]); 
		formData.append('<?=$this->security->get_csrf_token_name()?>', '<?=$this->security->get_csrf_hash()?>'); 
		$.ajax({
			type:'POST',
			url: $('#formupload').attr('action'),
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
				// var rt = JSON.parse(data);
				var rt = JSON.stringify(data);
				var rt = jQuery.parseJSON(rt);
				var srcImg = '<?=base_url('src/files/')?>'+rt.upload_data['file_name'];
				// alert('Success upload file: '+rt.upload_data['orig_name']);
				$('#files').val(tmp_files+rt.id_file+',');
				$('#file_list').append('<div id="sp-'+rt.id_file+'" class="col-6 text-center">'+
					'<a href="'+srcImg+'" target="_blank"><img src="'+srcImg+'" class="img-fluid rounded mt-2" height="75px" width="75px"></a>'+
					'<br>'+
					'<a href="#" onclick="deletefile(\'sp-'+rt.id_file+'\', \''+rt.upload_data['file_name']+'\')" class="fa fa-trash" style="color:red"></a>'+
					'</div> ');
				$('input[name=<?=$this->security->get_csrf_token_name()?>]').val(rt.csrf);
				$('#file_select').val('');
				// $.each(data, function(i, item) {
				//     alert(item[i].upload_data);
				// });​
			},
			error: function(data){
				alert(data);
			}
		});

	});


	function deletefile(id, name=''){
		var xid = id.split("-");
		var tmp_files = $('#files').val();
		var afilenya = [tmp_files];
		$.get('<?=site_url('files/delete/?filename=')?>'+name, function(d){
			// alert(d);
			if(d=='delete file '+name+''){
				$("#"+id).remove();
				tmp_files = tmp_files.replace(xid[1]+",", "");
				$('#files').val(tmp_files);
			}
		});
	}
</script>

<!-- source -->
<link type="text/css" rel="stylesheet" href="<?=base_url('src/plugins/')?>jQuery-TE_v.1.4.0/jquery-te-1.4.0.css">
<script type="text/javascript" src="<?=base_url('src/plugins/')?>jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
		$(".textEditor").jqte({placeholder:'type description...'});
		$(".textEditor").jqteVal('<?=$this->input->post('description')?>');
	});
</script>