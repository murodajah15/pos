<?php
include("./inc/config.php");

if (count($_POST)){
	$query = mysqli_query($connect, "select * from jualh where nojual='$_POST[nojual]'");
	$de = mysqli_fetch_assoc($query);	
	echo json_encode($de);
}
