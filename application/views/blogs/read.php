<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
</head>
<body>
	<h2><?=$title?></h2>
	<code><?=$data?></code>
	<hr>
	<a href="<?=site_url('welcome')?>">back</a>
	<hr>
	<?php
	$captcha = shell_exec('curl '.site_url('welcome/captcha').'');
	?>
	<img src="<?=$captcha?>">
	<br>
	<table style="border: 1px">
		<thead>
			<tr>
				<td>KODE</td>
				<td>NAME</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($isi as $key) {?>
			<tr bgcolor="red">
				<td><?=$key['kode_pro']?></td>
				<td><?=$key['provinsi']?>
 ( 
<?php 
echo count($key['isi2'])
?> Kabupaten/Kota )
</td>
			</tr>
			<?php foreach ($key['isi2'] as $key2) {?>
				<tr bgcolor="pink">
					<td><?=$key2['kode_kab']?></td>
					<td><?=$key2['kabupaten']?>
 ( 
<?php 
echo count($key2['isi3'])
?> Kecamatan )
</td>
				</tr>
				<?php foreach ($key2['isi3'] as $key3) {?>
					<tr bgcolor="orange">
						<td><?=$key3['kode_kec']?></td>
						<td><?=$key3['kecamatan']?>
 ( 
<?php 
echo count($key3['isi4'])
?> Kelurahan )
</td>
					</tr>
					<?php foreach ($key3['isi4'] as $key4) {?>
						<tr bgcolor="yellow">
							<td><?=$key4['kode_kel']?></td>
							<td><?=$key4['kelurahan']?></td>
						</tr>
					<?php }?>
				<?php }?>
			<?php }?>
		<?php }?>
		</tbody>
	</table>
</body>
</html>
