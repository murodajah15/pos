<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	$query = mysqli_query($connect, "select * from kasir_tagihan where id=$_GET[id]");
	$de = mysqli_fetch_assoc($query);
	if ($de['proses'] == 'Y') {
	?>
		<script>
			swal({
				title: "Gagal hapus data",
				text: "Data sudah diproses !",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=wo';
			});
		</script>
	<?php
		exit();
	}
	// $query = $connect->prepare("delete from kasir_tagihan where id=?");
	// $query->bind_param('s',$_GET['id']);
	if ($de['batal'] == 'N') {
		$batal = 'Y';
		$query = $connect->prepare("update kasir_tagihan set batal=? where id=?");
		$query->bind_param('ss', $batal, $_GET['id']);
	} else {
		$batal = 'N';
		$query = $connect->prepare("update kasir_tagihan set batal=? where id=?");
		$query->bind_param('ss', $batal, $_GET['id']);
	}
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		// echo "<script>alert('Data berhasil dihapus !');
		// window.location.href='../../dashboard.php?m=wo';
		// </script>";
	?>
		<script>
			swal({
				title: "Aksi berhasil",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=wo';
			});
		</script>
	<?php
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.location.href='../../dashboard.php?m=wo';
		// </script>";				
	?>
		<script>
			swal({
				title: "Aksi gagal",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=wo';
			});
		</script>
	<?php
	}
	//header("location:../../dashboard.php?m=wo");	
	?>
</body>