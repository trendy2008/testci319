


<?=form_open('sys/app/config_edit/?id='.$_GET['id'], array('class'=>'form'))?>
	<table>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td><input type="text" name="config_name" value="<?=$data->config_name?>" class="form-control"><?=form_error('config_name')?></td>
		</tr>
		<tr>
			<td>Value</td>
			<td>:</td>
			<td><textarea name="config_value" class="form-control"><?=$data->config_value?></textarea><?=form_error('config_value')?></td>
		</tr>
		<tr>
			<td>Status</td>
			<td>:</td>
			<td>
				<label><input type="radio" name="config_status" value="1" <?php if($data->config_status=='1'){echo 'checked="checked"';}?>>Aktif</label>
				<label><input type="radio" name="config_status" value="0" <?php if($data->config_status=='0'){echo 'checked="checked"';}?>>Non Aktif</label>
				<?=form_error('config_status')?>
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>:</td>
			<td><textarea name="config_desc" class="form-control"><?=$data->config_desc?></textarea><?=form_error('config_desc')?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<button type="submit">Submit</button>
				<button type="reset" onclick="window.location.assign('<?=site_url('sys/app/config_list')?>')">Batal</button>
			</td>
		</tr>
	</table>
<?=form_close()?>
<style type="text/css">
	td{
		vertical-align: top;
		padding: 5px;
	}
</style>