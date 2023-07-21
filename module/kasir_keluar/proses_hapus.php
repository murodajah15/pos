<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from kasir_keluarh where id='$_GET[id]'"));
	$nokwitansi = $de['nokwitansi'];
	if ($de['proses'] == 'Y') {
	?>
		<script>
			swal({
				title: "Data sudah diproses, tidak bisa Hapus Data",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=jual';
			});
		</script>
	<?php
		exit();
	}
	// $query = $connect->prepare("delete from kasir_keluard where nokwitansi=?");
	// $query->bind_param('s',$nokwitansi);
	// if($query->execute() and mysqli_affected_rows($connect)>0){
	// }
	// $query = $connect->prepare("delete from kasir_keluarh where id=?");
	// $query->bind_param('s',$_GET['id']);
	if ($de['batal'] == 'N') {
		$batal = 'Y';
		$query = $connect->prepare("update kasir_keluarh set batal=? where id=?");
		$query->bind_param('ss', $batal, $_GET['id']);
	} else {
		$batal = 'N';
		$query = $connect->prepare("update kasir_keluarh set batal=? where id=?");
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