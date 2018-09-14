<!DOCTYPE html>
<html>
<head>
	<title>Desing</title>
	<script type="text/javascript" src="<?=base_url()?>src/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>src/js/popper.min.js"></script>
	<link href="<?=base_url()?>src/plugins/bootstrap-4.1.3/css/bootstrap.css" rel="stylesheet" />
	<script src="<?=base_url()?>src/plugins/bootstrap-4.1.3/js/bootstrap.js"></script>
	<link href="<?=base_url()?>src/plugins/Font-Awesome-master/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet" />
</head>
<body>

	<?php $this->load->view('design/navbar')?>

	<main role="main" class="container-fluid mt-5 py-3">
		<div class="row">
			<div class="col-3">
				<!-- side bar -->
				<img src="https://layanan-ksp.go.id/web/src/icon_app/katalog_data.png" alt="..." class="rounded-circle img-fluid">
				<p class="lead">
				  Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.
				</p>
			</div>
			<div class="col-9">
				<!-- content -->
				<?php 
				if(isset($page)){
					$this->load->view($page);
				}
				?>
			</div>
		</div>
	</main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
      </div>
    </footer>

	<script type="text/javascript">

		$('#okbtn').on('click', function(){
			alert('ll');
			var rs = get_token_csrf();
			alert(rs);
		});
		
		function get_token_csrf()
		{
			var rs = null;
			$.get('<?=site_url('welcome/token_csrf')?>', function(r){
				rs = r;
				// rs = JSON.parse(r);
				return false;
				// alert(r);
			});
			return rs;
		}
	</script>
</body>
</html>