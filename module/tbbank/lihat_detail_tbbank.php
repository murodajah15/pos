<?php
	include("./inc/config.php");

	$kode=$_POST['kode'];
	$query = mysqli_query($connect,"select * from tbbank where kode='$kode'");
    $de=mysqli_fetch_assoc($query);
    $kode = htmlspecialchars($de['kode']);
	$nama = htmlspecialchars($de['nama']);
?>
<div class='col-md-12'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
	<tr><td>Kode</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kode']?>' readonly></td></tr>
	<tr><td>Nama</td> <td>  <input type=text class='form-control' name='nip' value='<?= $nama ?>' readonly></td></tr>
</div>