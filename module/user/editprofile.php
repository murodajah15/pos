<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		$username = $_POST['username'];
		// $update = mysqli_query($connect,"update user SET nama_lengkap='$_POST[nama_lengkap]',email='$_POST[email]',
		// telp='$_POST[telp]' WHERE username='$username'");
		// if($update){
		$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
		$username = $_POST['username'];
		$nama_lengkap = strip_tags($_POST['nama_lengkap']);
		$email = strip_tags($_POST['email']);
		$telp = strip_tags($_POST['telp']);
		$query = $connect->prepare("update user set nama_lengkap=?,email=?,telp=?,user_input=? where username=?");
		$query->bind_param('sssss',$nama_lengkap,$email,$telp,$user_input,$username);
		if($query->execute() and mysqli_affected_rows($connect)>0) {		

		// 	header("location:../../dashboard.php");
		// }else{
		// 	echo 'Gagal merubah password';
		// }
			?>
			<script>
				swal({title: "Profile berhasil diupdate", text: "", icon: 
				"success"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php			
		}else{
			?>
			<script>
				swal({title: "Gagal update profile", text: "Silahkan diulangi", icon: 
				"error"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php			
		}
	?>
</body>