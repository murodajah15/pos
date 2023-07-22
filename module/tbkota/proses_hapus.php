<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	$query = mysqli_query($connect, "select kode from tbkota where id='$_GET[id]'");
	$k = mysqli_fetch_assoc($query);
	$kode = $k['kode'];
	$query = $connect->prepare("select * from tunjanganh where kdkota=?");
	$query->bind_param('s', $kode);
	$result = $query->execute();
	$query->store_result();
	if ($query->num_rows >= "1") {
		// echo "<script>alert('Gagal hapus data!, sudah terpakai ditransaksi');
		// 	window.location.href='../../dashboard.php?m=tbkota';
		// 	</script>";							
	?>
		<script>
			swal({
				title: "Gagal dihapus",
				text: "Sudah terpakai ditransaksi",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbkota';
			});
		</script>
	<?php
		exit();
	}
	$query = $connect->prepare("delete from tbkota where id=?");
	$query->bind_param('i', $_GET['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		// echo "<script>alert('Data berhasil dihapus !');
		// window.location.href='../../dashboard.php?m=tbkota';
		// </script>";
	?>
		<script>
			swal({
				title: "Data berhasil dihapus",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbkota';
			});
		</script>
	<?php
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.location.href='../../dashboard.php?m=tbkota';
		// </script>";				
	?>
		<script>
			swal({
				title: "Gagal hapus data",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbkota';
			});
		</script>
	<?php
	}
	//header("location:../../dashboard.php?m=tbkota");	
	?>
</body>