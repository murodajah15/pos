<?php
	include("./inc/config.php");

	$kode=$_POST['kode'];
	$query = mysqli_query($connect,"select tbbarang.*,tbsatuan.kode as kdsatuan,tbsatuan.nama as nmsatuan,tbjnbrg.kode as kdjnbrg,tbjnbrg.nama as nmjnbrg,tbnegara.kode as kdnegara,tbnegara.nama as nmnegara,tbdiscount.kode as kddiscount,tbdiscount.nama as nmdiscount,tbmove.kode as kdmove,tbmove.nama as nmmove from tbbarang 
		left join tbsatuan on tbbarang.kdsatuan=tbsatuan.kode 
		left join tbjnbrg on tbbarang.kdjnbrg=tbjnbrg.kode 
		left join tbnegara on tbbarang.kdnegara=tbnegara.kode
		left join tbdiscount on tbbarang.kddiscount=tbdiscount.kode
		left join tbmove on tbbarang.kdmove=tbmove.kode
		where tbbarang.id='$kode'");
	$de=mysqli_fetch_assoc($query);
	$nama = htmlspecialchars($de['nama']);
?>
<div class='col-md-12'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
	<tr><td>Kode</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kode']?>' readonly></td></tr>
	<tr><td>Nama</td> <td>  <input type=text class='form-control' name='nip' value='<?= $nama ?>' readonly></td></tr>
	<tr><td>Satuan</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kdsatuan']."|".$de['nmsatuan'] ?>' readonly></td></tr>
	<tr><td>Lokasi</td><td><input type='text' class='form-control' size='50' id='lokasi' name='lokasi' value='<?=$de['lokasi']?>' readonly></tr></td>
	<tr><td>Jenis Barang</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kdjnbrg']."|".$de['nmjnbrg'] ?>' readonly></td></tr>
	<tr><td>Buatan</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kdnegara']."|".$de['nmnegara'] ?>' readonly></td></tr>
	<tr><td>Perputaran</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kdmove']."|".$de['nmmove'] ?>' readonly></td></tr>
	
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
	<tr><td>Discount</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['kddiscount']."|".$de['nmdiscount'] ?>' readonly></td></tr>
	<tr><td>Harga Jual</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['harga_jual'] ?>' readonly></td></tr>
	<tr><td>Harga Beli</td> <td>  <input type=text class='form-control' name='nama_alias'value='<?= $de['harga_beli'] ?>' readonly></td></tr>
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
	<tr><td>Stock</td> <td>  <input type=text class='form-control' name='nama_alias' value='<?= $de['stock'] ?>' readonly></td></tr>
	<tr><td>Stock Minimum</td> <td>  <input type=text class='form-control' name='nip' value='<?= $de['stock_min'] ?>' readonly></td></tr>
	<tr><td>Stock Maksimum</td> <td>  <input type=text class='form-control' name='nama_alias' value='<?= $de['stock_mak'] ?>' readonly></td></tr>
	</table>
</div>