<?php
	include "../../inc/config.php";
	if(!empty($_POST['cmodule'])){
	//proses simpan
	date_default_timezone_set('Asia/Jakarta');
	//Cek Double
	$cek = mysqli_num_rows(mysqli_query($connect,"select * from tbmodule where nama='$_POST[cmodule]' and clain<>'$_POST[clain]' and id<>'$_POST[id]'"));
	if ($cek > 0){
		echo "<script>alert('Module tersebut sudah digunakan, tidak bisa simpan data !');history.go(-1) </script>";
		exit();
	}
	$user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
	$query = mysqli_query($connect,"update tbmodule set cmodule='$_POST[cmodule]',cmenu='$_POST[cmenu]',nurut='$_POST[nurut]',clain='$_POST[clain]',
	cmainmenu='$_POST[cmainmenu]',nlevel='$_POST[nlevel]' where id='$_POST[id]'");
	if($query){
		header("location:../../dashboard.php?m=tbmodule");
	}else{
		echo "<script>alert('Gagal Simpan Data !');history.go(-1);</script>";
	}	
}else{
	header("location:../../dashboard.php?m=tbmodule");
}
?>
