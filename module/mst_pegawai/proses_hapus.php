<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		// $sql=mysqli_query($connect,"select * from tunjangan where nip='$_GET[nip]'");
		// $jumrec = mysqli_num_rows($sql);
		// if ($jumrec>0) {
		// 	echo "<script>alert('Gagal hapus data !, sudah terpakai di transaksi !');history.go(-1);</script>";
		// }else{	
		// 	$sql=mysqli_query($connect,"delete from mst_pegawai where id='$_GET[id]'");
		// 	if ($sql>0) {
		// 		echo "<script>alert('Berhasil dihapus !');history.go(-1);</script>";
		// 	}else{
		// 		echo "<script>alert('Gagal hapus data !');history.go(-1);</script>";
		// 	}
		// }
		// header("location:../../dashboard.php?m=mst_pegawai");

		$query = mysqli_query($connect,"select * from mst_pegawai where id='$_GET[id]'");
		$k = mysqli_fetch_assoc($query);
		$nip = $k['nip'];
		$query = $connect->prepare("select * from tunjangan where nip=?");
		$query->bind_param('s',$nip);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			?>
			<script>
				swal({title: "Gagal dihapus", text: "Sudah terpakai ditransaksi", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_pegawai';
				   }
				);
			</script>
			<?php
			exit();
		}
		$query = $connect->prepare("delete from mst_pegawai where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.location.href='../../dashboard.php?m=mst_pegawai';
				   }
				);
			</script>
			<?php
		}else{
			?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_pegawai';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>
