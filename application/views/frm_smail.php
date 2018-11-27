
<div class="card">
	<div class="card-header">
		Form Send mail
	</div>
	<div class="card-body">
	
		<?=form_open()?>
		<table>
			<tr>
				<td width="100">Subject</td>
				<td width="10">:</td>
				<td width="">
					<input type="text" name="subject" class="form-control" required="required">
					<?=form_error('subject')?>
				</td>
			</tr>
			<tr>
				<td>To</td>
				<td>:</td>
				<td>
					<input type="text" name="to" class="form-control" required="required">
					<?=form_error('to')?>
				</td>
			</tr>
			<tr>
				<td>CC</td>
				<td>:</td>
				<td>
					<input type="text" name="cc" class="form-control">
					<?=form_error('cc')?>
				</td>
			</tr>
			<tr>
				<td>Message</td>
				<td>:</td>
				<td>
					<textarea name="message" class="form-control textEditor" rows="5"></textarea>
					<?=form_error('message')?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<button type="submit">Submit</button>
				</td>
			</tr>
		</table>
		<?=form_close()?>


		<?php
			if($this->session->flashdata('fmsg')){
				echo '<br><code>';
				echo $this->session->flashdata('fmsg');
				echo '</code>';
			}
		?>

		<hr>
		Test Autocomplete:
		<input type="text" name="peserta_instansi" id="peserta_instansi" size="40" value="" class="form-control">
		<link rel="stylesheet" href="<?php echo base_url()?>src/plugins/jquery-ui-1.12.1/jquery-ui.min.css" />
		<script src="<?php echo base_url()?>src/plugins/jquery-ui-1.12.1/jquery-ui.min.js"></script>
		<script type="text/javascript">
			function get_search_instansi()
			{
				$.get('<?=site_url('welcome/search_instansi')?>', {val:$('#peserta_instansi').val()}, function(d){
					var availableTags = JSON.parse(d);
					// var availableTags = JQuery.parseJSON(d);
				    $( "#peserta_instansi" ).autocomplete({
				      source: availableTags,
				    });
				});
			}

			$('#peserta_instansi').on('input', function(){
				get_search_instansi();
			});
		</script>
		<style type="text/css">
			.ui-autocomplete-input {
				z-index: 1511;
			}
			.ui-menu .ui-menu-item a {
				font-size: 12px;
			}
			.ui-autocomplete {
				z-index: 1510 !important;
			}
		</style>

	</div>
</div>
<!-- source -->
<link type="text/css" rel="stylesheet" href="<?=base_url('src/plugins/')?>jQuery-TE_v.1.4.0/jquery-te-1.4.0.css">
<script type="text/javascript" src="<?=base_url('src/plugins/')?>jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
		$(".textEditor").jqte({placeholder:'type description...'});
		$(".textEditor").jqteVal('<?=$this->input->post('description')?>');
	});
</script>
<style type="text/css">
	td{
		padding: 5px;
	}
</style>