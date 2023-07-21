<?php
	if(!empty($_POST['cmodule'])){
		//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from tbmodule where cmodule='$_POST[cmodule]' and clain='$_POST[clain]'"));
			if ($cek > 0){
				echo "<script>alert('Module tersebut sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$query = mysqli_query($connect,"insert into tbmodule (nurut,cmodule,cmenu,cmainmenu,clain,nlevel) values 
			('$_POST[nurut]','$_POST[cmodule]','$_POST[cmenu]','$_POST[cmainmenu]','$_POST[clain]','$_POST[nlevel]')");
			if($query){
				header("location:../../dashboard.php?m=tbmodule");
			}else{
				echo "<script>alert('Gagal Simpan Data !');history.go(-1);</script>";
			}
	}else{
		header("location:../../dashboard.php?m=tbmodule");
	}
?>