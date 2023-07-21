<?php
	include 'cek_akses.php';
?>

<?php
	if ($aksesok == 'Y') {
?>

<font face="calibri">
<h3>Restore Database</h3>
	<a class='btn btn-danger' href='module/user/proses_restore.php'
	onClick='return confirm(\"Anda yakin akan proses restore database ?\")'>
	<span class='glyphicon glyphicon-record'></span></button> Proses Restore</a>
<?php
}else{
	echo "<font color='red'>Anda tidak punya hak !</font>";
}?>
<?php
/*<td><a href='tampil_gambar.php?wahyu.jpg' target='blank'>$k[picture]</a></td>
/*<td><img src='.images/promo/".$k['picture']."' width='100' height='100'></td>**/
