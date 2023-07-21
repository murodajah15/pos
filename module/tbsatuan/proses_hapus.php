<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$query = $connect->prepare("select * from tbbarang where kdsatuan=?");
		$query->bind_param('s',$_GET['kode']);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			// echo "<script>alert('Gagal hapus data!, sudah terpakai ditransaksi');
			// 	window.location.href='../../dashboard.php?m=tbsatuan';
			// 	</script>";							
			?>
			<script>
				swal({title: "Gagal dihapus", text: "Sudah terpakai ditransaksi", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsatuan';
				   }
				);
			</script>
			<?php
			exit();
		}
		$query = $connect->prepare("delete from tbsatuan where id=?");
		$query->bind_param('i',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=tbsatuan';
			// </script>";
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsatuan';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=tbsatuan';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsatuan';
				   }
				);
			</script>
			<?php
		}		
	//header("location:../../dashboard.php?m=tbsatuan");	
	?>
</body>
