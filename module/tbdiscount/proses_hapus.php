<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
<<<<<<< HEAD
	<?php
	include "../../inc/config.php";
	$query = mysqli_query($connect, "select * from tbdiscount where id='$_GET[id]'");
	$row = mysqli_fetch_array($query);
	$kddiscount = $row['kode'];
	$query = $connect->prepare("select * from tbbarang where kddiscount=?");
	$query->bind_param('s', $kddiscount);
	$result = $query->execute();
	$query->store_result();
	if ($query->num_rows >= "1") {
		// echo "<script>alert('Gagal hapus data!, sudah terpakai ditransaksi');
		// 	window.location.href='../../dashboard.php?m=tbdiscount';
		// 	</script>";							
	?>
		<script>
			swal({
				title: "Gagal dihapus",
				text: "Sudah terpakai ditransaksi",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbdiscount';
			});
		</script>
	<?php
		exit();
	}
	$query = $connect->prepare("delete from tbdiscount where id=?");
	$query->bind_param('i', $_GET['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		// echo "<script>alert('Data berhasil dihapus !');
		// window.location.href='../../dashboard.php?m=tbdiscount';
		// </script>";
	?>
		<script>
			swal({
				title: "Data berhasil dihapus",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbdiscount';
			});
		</script>
	<?php
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.location.href='../../dashboard.php?m=tbdiscount';
		// </script>";				
	?>
		<script>
			swal({
				title: "Gagal hapus data",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbdiscount';
			});
		</script>
	<?php
	}
=======
   	<?php
		include "../../inc/config.php";
		$query = mysqli_query($connect, "select * from tbdiscount where id='$_GET[id]'");
		$row = mysqli_fetch_array($query);
		$kddiscount = $row['kode'];
		$query = $connect->prepare("select * from tbbarang where kddiscount=?");
		$query->bind_param('s',$kddiscount);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			// echo "<script>alert('Gagal hapus data!, sudah terpakai ditransaksi');
			// 	window.location.href='../../dashboard.php?m=tbdiscount';
			// 	</script>";							
			?>
			<script>
				swal({title: "Gagal dihapus", text: "Sudah terpakai ditransaksi", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbdiscount';
				   }
				);
			</script>
			<?php
			exit();
		}
		$query = $connect->prepare("delete from tbdiscount where id=?");
		$query->bind_param('i',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=tbdiscount';
			// </script>";
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbdiscount';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=tbdiscount';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbdiscount';
				   }
				);
			</script>
			<?php
		}		
>>>>>>> 5fdc443611545cb678fe38d60c3c39e48e542220
	//header("location:../../dashboard.php?m=tbdiscount");	
	?>
</body>