<?php
	//proses simpan
	include "../../inc/config.php";
	date_default_timezone_set('Asia/Jakarta');
	//Cek Double
	$data = mysqli_query($connect,"select * from tbmodule order by nurut");
	mysqli_query($connect,"TRUNCATE TABLE tbmodule");
	$no=1;
	while($de=mysqli_fetch_assoc($data)){
		mysqli_query($connect,"insert into tbmodule (nurut,cmodule,cmenu,cmainmenu,clain,nlevel) values 
		('$no','$de[cmodule]','$de[cmenu]','$de[cmainmenu]','$de[clain]','$de[nlevel]')");
		$no++;
	}
	header("location:../../dashboard.php?m=tbmodule");

?>