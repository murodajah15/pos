<?php
	include "../../inc/config.php";
	//echo $_POST['username'];
	//select * from userdtl where username='MUROD1'
	//Hapus dahulu userdtl yang tidak terdapat di tbmodule
	//mysqli_query($connect,"delete from userdtl where username='$_POST[username]'");
	$id = $_POST['id'];
	$username = $_POST['username'];
	$query = $connect->prepare("delete from userdtl where username=?");
	$query->bind_param('s',$username);
	if($query->execute()) {
		$sql=mysqli_query($connect,"select * from tbmodule order by nurut");
		while($de=mysqli_fetch_assoc($sql)){
			$idmodule = $de['id'];
			$cmodule = $de['cmodule'];
			$cmainmenu = $de['cmainmenu'];
			$nlevel = $de['nlevel'];
			$nurut = $de['nurut'];
			$query = $connect->prepare("INSERT INTO userdtl (iduser,idmodule,username,cmodule,cmainmenu,nlevel,nurut) values (?,?,?,?,?,?,?)");
			$query->bind_param('iisssii',$id,$idmodule,$username,$cmodule,$cmainmenu,$nlevel,$nurut);			
			if($query->execute()) {
			}
			$query=mysqli_query($connect,"select * from tbmodule order by nurut");
			while($k=mysqli_fetch_assoc($query)){
				$idmodule = $k['id'];
				if (isset($_POST['checkboxpakai'.$idmodule])){ $lnpakai = 1; }else{$lnpakai=0;}
				if (isset($_POST['checkboxtambah'.$idmodule])){ $lntambah = 1; }else{$lntambah=0;}
				if (isset($_POST['checkboxedit'.$idmodule])){ $lnedit = 1; }else{$lnedit=0;}
				if (isset($_POST['checkboxhapus'.$idmodule])){ $lnhapus = 1; }else{$lnhapus=0;}
				if (isset($_POST['checkboxproses'.$idmodule])){ $lnproses = 1; }else{$lnproses=0;}
				if (isset($_POST['checkboxunproses'.$idmodule])){ $lnunproses = 1; }else{$lnunproses=0;}
				if (isset($_POST['checkboxcetak'.$idmodule])){ $lncetak = 1; }else{$lncetak=0;}
				$update = $connect->prepare("update userdtl set pakai=?,tambah=?,edit=?,hapus=?,proses=?,unproses=?,cetak=? where username=? and idmodule=?");
				$update->bind_param('iiiiiiisi',$lnpakai,$lntambah,$lnedit,$lnhapus,$lnproses,$lnunproses,$lncetak,$username,$idmodule);			
				if($update->execute()) {
				}else{
					echo "<script>alert('Tidak bisa update data !');history.go(-1) </script>";
					exit();
				}
				// $cek=mysqli_query($connect,"update userdtl set pakai='$lnpakai',tambah='$lntambah',edit='$lnedit',
				// hapus='$lnhapus',proses='$lnproses',unproses='$lnunproses',cetak='$lncetak' where username='$_POST[username]' and idmodule='$idmodule'");
				// if ($cek < 1){
				// 	echo "<script>alert('Tidak bisa update data !');history.go(-1) </script>";
				// 	exit();
				// }
			}	
		}
	}

	header("location:../../dashboard.php?m=user");
?>