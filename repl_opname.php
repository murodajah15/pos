<?php
include("./inc/config.php");

if (count($_POST)){
    $noopname = $_POST['kode_barang'];
    echo "<script>alert('test')</script>";
	$query = mysqli_query($connect, "select * from opnameh where noopname='$noopname");
	$de = mysqli_fetch_assoc($query);	
    echo json_encode($de);
}
