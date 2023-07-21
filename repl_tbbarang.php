<?php
include("./inc/config.php");

if (count($_POST)){
	$kdbarang = $_POST['kode_barang'];
	$query = mysqli_query($connect, "select * from tbbarang where kode='$_POST[kode_barang]'");
	$de = mysqli_fetch_assoc($query);	
	echo json_encode($de);
}
