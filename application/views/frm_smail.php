
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