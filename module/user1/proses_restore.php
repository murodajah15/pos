<?php
	include "../../inc/config.php";
	$table_name = "mst_rekening";
	$query = "delete from ".$table_name;
	mysqli_query($connect,$query);
	$backup_file  = "d:/temp/mst_rekening.sql";
	$sql = "LOAD DATA INFILE '$backup_file' INTO TABLE $table_name";
	$restore = mysqli_query($connect,$sql);
	if(! $restore  )
	{
	  die('Gagal load data : ' . mysqli_error($connect));
	}
	/*echo "Restore data berhasil\n";**/
	echo "<script>alert('Restore data berhasil !');history.go(-3) </script>";
?>