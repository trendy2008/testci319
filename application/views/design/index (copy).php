<!DOCTYPE html>
<html>
<head>
	<title>Desing</title>
	<script type="text/javascript" src="<?=base_url()?>src/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>src/js/popper.min.js"></script>
	<link href="<?=base_url()?>src/plugins/bootstrap-4.1.3/css/bootstrap.css" rel="stylesheet" />
	<script src="<?=base_url()?>src/plugins/bootstrap-4.1.3/js/bootstrap.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
		<div class="container-fluid">
		  <a class="navbar-brand" href="#">Navbar</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Dropdown
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="#">Action</a>
		          <a class="dropdown-item" href="#">Another action</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" href="#">Something else here</a>
		        </div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#">Disabled</a>
		      </li>
		    </ul>
		    <form class="form-inline my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
		      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		    </form>
		  </div>	
		</div>
	</nav>	

	<div class="container-fluid mt-5">
		<div class="row">
			<div class="col-3">
				side bar
				<img src="https://layanan-ksp.go.id/web/src/icon_app/katalog_data.png" alt="..." class="rounded-circle img-fluid">
				<p class="lead">
				  Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.
				</p>
			</div>
			<div class="col-9">
				content
				<?php 
				if(isset($page)){
					$this->load->view($page);
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<p>You can use the mark tag to <mark>highlight</mark> text.</p>
				<p><del>This line of text is meant to be treated as deleted text.</del></p>
				<p><s>This line of text is meant to be treated as no longer accurate.</s></p>
				<p><ins>This line of text is meant to be treated as an addition to the document.</ins></p>
				<p><u>This line of text will render as underlined</u></p>
				<p><small>This line of text is meant to be treated as fine print.</small></p>
				<p><strong>This line rendered as bold text.</strong></p>
				<p><em>This line rendered as italicized text.</em></p>
				<hr>
				<h1 class="display-1">Display 1</h1>
				<h1 class="display-2">Display 2</h1>
				<h1 class="display-3">Display 3</h1>
				<h1 class="display-4">Display 4</h1>
			</div>
			<div class="col-6">
				<blockquote class="blockquote">
				  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
				</blockquote>
				<hr>
				<blockquote class="blockquote text-center">
				  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
				  <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
				</blockquote>
				<hr>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  <h4 class="alert-heading">Well done!</h4>
				  <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
				  <hr>
				  <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
				</div>
				<hr>
				<button type="button" class="btn btn-primary">
				  Notifications <span class="badge badge-light">4</span>
				</button>
				<br>
				<span class="badge badge-primary">Primary</span>
				<span class="badge badge-secondary">Secondary</span>
				<span class="badge badge-success">Success</span>
				<span class="badge badge-danger">Danger</span>
				<span class="badge badge-warning">Warning</span>
				<span class="badge badge-info">Info</span>
				<span class="badge badge-light">Light</span>
				<span class="badge badge-dark">Dark</span>
				<hr>
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="#">Home</a></li>
				    <li class="breadcrumb-item"><a href="#">Library</a></li>
				    <li class="breadcrumb-item active" aria-current="page">Data</li>
				  </ol>
				</nav>
				<hr>
				<button type="button" class="btn btn-primary">Primary</button>
				<button type="button" class="btn btn-secondary">Secondary</button>
				<button type="button" class="btn btn-success">Success</button>
				<button type="button" class="btn btn-danger">Danger</button>
				<button type="button" class="btn btn-warning">Warning</button>
				<button type="button" class="btn btn-info">Info</button>
				<button type="button" class="btn btn-light">Light</button>
				<button type="button" class="btn btn-dark">Dark</button>
				<button type="button" class="btn btn-link">Link</button>
				<br>
				<button type="button" class="btn btn-outline-primary">Primary</button>
				<button type="button" class="btn btn-outline-secondary">Secondary</button>
				<button type="button" class="btn btn-outline-success">Success</button>
				<button type="button" class="btn btn-outline-danger">Danger</button>
				<button type="button" class="btn btn-outline-warning">Warning</button>
				<button type="button" class="btn btn-outline-info">Info</button>
				<button type="button" class="btn btn-outline-light">Light</button>
				<button type="button" class="btn btn-outline-dark">Dark</button>
				<br>
				<div class="input-group">
					<div class="input-group-prepend">
					 	<div class="input-group-text" id="btnGroupAddon2">@</div>
					</div>
					<input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon2">
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		
		function get_token()
		{
			$.get('<?=site_url('welcome/token_csrf')?>', function(r){
				return r;
			});
		}
	</script>
</body>
</html>