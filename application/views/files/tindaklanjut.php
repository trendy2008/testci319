<?=form_open_multipart(str_replace(array('/tindaklanjut/index.php/','/rapim/index.php/'), array('',''), $_SERVER['REQUEST_URI']), array('style'=>'font-size:16px; width:', 'class'=>'form'))?>

<table class="table table-striped borderless">
	<tr>
		<td width="20%">Tindak Lanjut</td>
		<td>:</td>
		<td><?=$tndk->tndk_tugas?></td>
	</tr>
	<tr>
		<td>Output yang diminta</td>
		<td>:</td>
		<td>
			<?php 
			// $toutput = $this->open->create_array($tndk->tndk_output,',');
			// $output = '';
			// foreach ($this->open->arr_output_tndk() as $key => $value) if(!array_keys(array('',0),$key) && array_keys($toutput, $key)){
			// 	$output .= '<span>'.$value.'</span>, ';
			// } 
			// echo $output = substr($output, 0, -2);
			echo $tndk->tndk_output;
			?>
		</td>
	</tr>
	<tr>
		<td>Batas waktu</td>
		<td>:</td>
		<td>
			<?php 
			echo $this->open->tanggal($tndk->tndk_batasakhir,1);
			if($tndk->tndk_respons<>''){
				$sisa = ($this->db->query("SELECT DATEDIFF('".$tndk->tndk_batasakhir."', '".substr($tndk->tndk_respons,0,9)."') as total ")->row()->total);
				if($sisa<0){
					echo $progres = ' (Over Due ['.$this->open->status_tindaklanjut($tndk->tndk_status).'])';
				}else{
					if(array_keys(array(1,2,3),$tndk->tndk_status)){
						echo $progres = ' ('.$this->open->status_tindaklanjut($tndk->tndk_status).')';
					}else{
						echo $progres = ' ('.$this->open->status_tindaklanjut($tndk->tndk_status).')';
					}
				}
			}else{
				$sisa = ($this->db->query("SELECT DATEDIFF('".$tndk->tndk_batasakhir."', '".date('Y-m-d')."') as total ")->row()->total); #($tndk->tndk_batasakhir - date('Y-m-d'));
				if($sisa<0){
					echo ' (Sudah terlewat)';
				}elseif($sisa==0){
					echo ' (Hari ini)';
				}else{
					echo ' ('.$sisa.' Hari Lagi)';
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<td>Keterangan Tindak Lanjut</td>
		<td>:</td>
		<td>
			<textarea name="tindaklanjutnya" placeholder="keterangan Tindak lanjut..." rows="6" cols="60" required="required" class="form-control"><?=$tndk->tndk_value?></textarea>
			<?=form_error('tindaklanjutnya')?>
		</td>
	</tr>
	<?php if($sisa<0 && $tndk->tndk_respons==''){?>
	<tr>
		<td>Alasan Kendala</td>
		<td>:</td>
		<td>
			<textarea name="kendala" placeholder="Alasan Kendala" rows="6" cols="60" required="required" class="form-control"><?=$tndk->tndk_value?></textarea>
			<?=form_error('kendala')?>	
		</td>
	</tr>
	<?php }?>
	<tr>
		<td>File Output</td>
		<td>:</td>
		<td>
			<input type="file" name="fileoutput" id="fileoutput">
			<?php
			$int_fileout = '';
			if($tndk->tndk_fileoutput<>''){
				$int_fileout = $tndk->tndk_fileoutput.',';
			}
			?>
			<input type="hidden" name="filenya" id="filenya" value="<?=$int_fileout?>">
			<code id="listfile">
				<?php
				$fout = $this->open->create_array($tndk->tndk_fileoutput, ',');
				if(!empty($fout)){
					foreach ($fout as $key => $value) {
						$xfile = $this->db->get_where('files', array('file_id'=>$value))->row();
						if(!empty($xfile)){
							echo '<span id="sp-'.$xfile->file_id.'"><a href="'.site_url('files/download/?filename='.$xfile->file_name).'" target="_blank">'.$xfile->client_name.'</a> ';
							echo '<a href="#" onclick="deletefile(\'sp-'.$xfile->file_id.'\', \''.$xfile->file_name.'\')" class="fa fa-remove" style="color:red"></a><br></span>';
						}
					}
				}else{
					echo '<span style="color:red">tidak ada file yang diupload</span>';
				}
				?>
			</code>
		</td>
	</tr>
	<tr>
		<td>Status</td>
		<td>:</td>
		<td>
			<select name="status_tindaklanjut" required="required">
				<option value="">Pilih status</option>
				<?php 
				foreach ($this->open->arr_status_tindaklanjut() as $key => $value) if($key >2 && $key>=$tndk->tndk_status){
					echo'<option value="'.$key.'" ';
						if($key==$tndk->tndk_status){echo'selected="selected"';}
					echo'>'.$value.'</option>';
				}?>
			</select>
			<?=form_error('status_tindaklanjut')?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<button type="submit" class="btn btn-success btn-sm">Submit</button>
			<?php if($this->session->userdata('fc')=='index'){?>
				<a href="<?=site_url('tindaklanjut/index')?>" class="btn btn-default btn-sm">Cancel</a>
			<?php }else{?>
				<a href="<?=site_url('tindaklanjut/active/?rapat='.$this->open->encode($tndk->rapat_id))?>" class="btn btn-default btn-sm">Cancel</a>
			<?php } ?>
		</td>
	</tr>
</table>
<style type="text/css">
.borderless td, .borderless th {
    border: none;
}
</style>
<?=form_close()?>
<style type="text/css">
	td{
		padding-top: 1px;
		padding-bottom: 1px;
		padding-left: 3px;
		padding-right: 3px;
	}
</style>
<?=form_open_multipart('files/upload/?id='.$tndk->rapat_id.'-'.$tndk->not_id.'-'.$tndk->tndk_id, array('id'=>'formupload'));
form_close();?>
<script type="text/javascript">

	$('#fileoutput').on('change', function(){
		var filenya = $('#filenya').val();
		var formData = new FormData();
		formData.append('userfile', $('input[type=file]')[0].files[0]); 
		formData.append('csrf_test_name', '<?=$this->security->get_csrf_hash()?>'); 
		$.ajax({
			type:'POST',
			url: $('#formupload').attr('action'),
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
				// alert(data);
				var rt = JSON.parse(data);
				alert('Berhasil upload file: '+rt.upload_data['orig_name']);
				$('#filenya').val(filenya+rt.id_file+',');
				$('#listfile').append('<span id="sp-'+rt.id_file+'"><a href="" target="_blank">'+rt.upload_data['orig_name']+'</a><a href="#" onclick="deletefile(\'sp-'+rt.id_file+'\', \''+rt.upload_data['file_name']+'\')" class="fa fa-remove" style="color:red"></a><br></span> ');
				$('input[name=csrf_test_name]').val(rt.csrf);
			},
			error: function(data){
				alert(data);
				// $('#facebox .content').empty().html(data);
			}
		});

	});


	function deletefile(id, name=''){
		var xid = id.split("-");
		var filenya = $('#filenya').val();
		var afilenya = [filenya];
		$.get('<?=site_url('files/delete/?filename=')?>'+name, function(d){
			alert(d);
			if(d=='delete file '+name+''){
				$("#"+id).remove();
				filenya = filenya.replace(xid[1]+",", "");
				$('#filenya').val(filenya);
			}
		});
	}

</script>
<?php