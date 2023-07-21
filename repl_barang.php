<?php
include("./inc/config.php");

if (count($_POST)){
	$kdcustomer = $_POST['kode_customer'];
	$kdbarang = $_POST['kode_barang'];
	//$query = mysqli_query($connect, "select * from tbbarang where kode='$_POST[kode_barang]'");
	//$query = mysqli_query($connect, "select tbmultiprc.nmbarang as nama,tbmultiprc.harga as harga_jual from tbmultiprc where kdbarang='$_POST[kode_barang]' and kdcustomer='$kdcustomer'");
	$query = mysqli_query($connect, "select tbmultiprc.nmbarang as nama,tbmultiprc.harga as harga_jual,tbbarang.kdsatuan from tbmultiprc inner join tbbarang on tbbarang.kode=tbmultiprc.kdbarang where kdbarang='$_POST[kode_barang]' and kdcustomer='$kdcustomer'");	
//$query = mysqli_query($connect, "select tbmultiprc.kdbarang as kode,tbmultiprc.nmbarang as nama,tbmultiprc.harga as harga_jual,tbbarang.kdsatuan as kdsatuan from tbmultiprc inner join tbbrang on tbbarang.kode=tbmultiprc.kdbarang where tbmultiprc.kdbarang='$_POST[kode_barang]' and tbmultiprc.kdcustomer='$kdcustomer'");	
	$de = mysqli_fetch_assoc($query);	
	echo json_encode($de);
}
