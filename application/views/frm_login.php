

<div class="card">
	<div class="card-header">
		Login 
	</div>
	<div class="card-body">
		
		<?php echo form_open()?>

			<table>
				<tr>
					<td>User</td>
					<td>:</td>
					<td>
						<input type="text" name="username" placeholder="username">
					</td>
				</tr>
				<tr>
					<td>Password</td>
					<td>:</td>
					<td>
						<input type="password" name="password" placeholder="password">
					</td>
				</tr>
				<tr>
					<td>Captcha</td>
					<td>:</td>
					<td>
						<input type="text" name="captcha" placeholder="captcha">
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<img src="" id="captcha-img" onclick="get_captcha_img()">
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
		
		<?php echo form_close()?>

	</div>
</div>
<script type="text/javascript">
	
	$(function(){
		get_captcha_img();
	})


	function get_captcha_img()
	{
		$.get('<?=site_url('welcome/captcha')?>', function(img){
			$('#captcha-img').attr('src', img);
		})
	}


	$('form').on('submit', function(e){
		var rslt;
		e.preventDefault();
		// for (instance in CKEDITOR.instances) {
		// 	CKEDITOR.instances[instance].updateElement();
		// }
		var formData = new FormData(this);
		$.ajax({
			type: 'POST',
			url: $('form').attr('action'),
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				rslt = JSON.stringify(data);
				rslt = jQuery.parseJSON(rslt);
				alert(rslt+'....'+rslt.username);
			},
			error: function(data){
				alert(data);
			}
		});
	});

</script>