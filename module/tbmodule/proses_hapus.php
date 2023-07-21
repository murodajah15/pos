<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		// mysqli_query($connect,"delete from tbmodule where id='$_GET[id]'");
		// echo "<script>alert('Berhasil dihapus!');history.go(-1);</script>";
		// header("location:../../dashboard.php?m=tbmodule");
		$query = $connect->prepare("delete from tbmodule where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=tbbank';
			// </script>";
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=tbbank';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>
