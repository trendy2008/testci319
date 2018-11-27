

<div class="card">
	<div class="card-header font-weight-bold"><?=$title?></div>
	<div class="card-body">
	
		<?=form_open('galery/edit/?id='.$this->lopen->encode($data->id), array('class'=>'form'))?>
		<div class="row">
			<div class="col-8">
			
				<b>Title:</b>
				<input type="text" name="title" value="<?=($this->input->post('title'))?:$data->title?>" required="required" class="form-control" placeholder="title....">
				<?=form_error('title')?>

				<br>
				<b>Description:</b>
				<textarea name="description" required="required" class="form-control textEditor" placeholder="description..."></textarea>
				<?=form_error('description')?>

				<b>Select File:</b>
				<input type="file" name="file_select" id="file_select" class="">
				<input type="hidden" name="files" id="files" value="<?=($this->input->post('files'))?:(($data->files)?$data->files.',':$data->files)?>">

				<?php $status = ($this->input->post('status'))?:$data->status;
				if($status==0){?>
				<br><br>
				<b>Statsu:</b>
				<label><input type="radio" name="status" value="1" <?php if($status==1){echo'checked';}?>>Aktif</label>
				<label><input type="radio" name="status" value="0" <?php if($status==0){echo'checked';}?>>Delete</label>
				<?=form_error('status');
				}?>

				<hr>
				<button type="submit" style="" class="btn btn-primary btn-md">Simpan</button>
				<button type="reset" style="" class="btn btn-primary btn-md" onclick="window.location.assign('<?=site_url('galery')?>')">Batal</button>

			</div>
			<div class="col-4">

				<b>Files Upload:</b>
				<div id="file_list" class="row">
					<?php
					$fout = explode(',', $data->files);
					if(!empty($fout)){
						foreach ($fout as $key => $value) {
							$xfile = $this->db->get_where('files', array('file_id'=>$value))->row();
							if(!empty($xfile)){
								$srcImg = base_url('src/files/'.$xfile->file_name);
								echo'<div id="sp-'.$xfile->file_id.'" class="col-6 text-center">
									<a href="'.$srcImg.'" target="_blank"><img src="'.$srcImg.'" class="img-fluid rounded mt-2" height="75px" width="75px"></a>
									<br>
									<a href="'.site_url('files/download/?filename='.$xfile->file_name).'" target="_blank" class="fa fa-download" style="color:green"></a>
									<a href="#" onclick="deletefile(\'sp-'.$xfile->file_id.'\', \''.$xfile->file_name.'\')" class="fa fa-trash" style="color:red"></a>
								</div> ';
							}
						}
					}else{
						echo '<span style="color:red">tidak ada file yang diupload</span>';
					}
					?>
				</div>
				
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
					'<a href="<?=site_url('files/download/?filename=')?>'+rt.upload_data['file_name']+'" target="_blank" class="fa fa-download" style="color:green"></a>'+
					'<a href="#" onclick="deletefile(\'sp-'+rt.id_file+'\', \''+rt.upload_data['file_name']+'\')" class="fa fa-trash" style="color:red"></a>'+
					'</div> ');
				$('input[name=<?=$this->security->get_csrf_token_name()?>]').val(rt.csrf);
				$('#file_select').val('');
				// $.each(data, function(i, item) {
				//     alert(item.file_name);
				// });​
			},
			error: function(data){
				alert(data);
			}
		});

	});


	function deletefile(id, name=''){
		var cf = confirm('hapus file ?');
		if(cf==true)
		{
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
	}
</script>

<!-- source -->
<link type="text/css" rel="stylesheet" href="<?=base_url('src/plugins/')?>jQuery-TE_v.1.4.0/jquery-te-1.4.0.css">
<script type="text/javascript" src="<?=base_url('src/plugins/')?>jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
		$(".textEditor").jqte({placeholder:'type description...'});
		$(".textEditor").jqteVal('<?=($this->input->post('description'))?:$data->description?>');
	});
</script>