<?php
	include "../../inc/config.php";
	session_start();
	//proses simpan
	date_default_timezone_set('Asia/Jakarta');
	$id = $_GET['id'];
	$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from tbbank where id='$id'"));
	$_SESSION['kdbank'] = $de['kode'];
	$_SESSION['nmbank'] = $de['nama'];
	//echo '<a href="window.history.go(-2)"></a>';
	echo "<script>history.go(-2);</script>";
exit;
?>
