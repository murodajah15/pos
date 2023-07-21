<?php
include("./inc/config.php");

if (count($_POST)){
	$query = mysqli_query($connect, "select * from tbjnkeluar where kode='$_POST[data_jnkeluar]'");
	$de = mysqli_fetch_assoc($query);	
	echo json_encode($de);
}
