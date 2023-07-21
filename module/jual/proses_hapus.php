<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	$user = $_SESSION['username'];
	$user_proses = "Proses-" . $user . "-" . date('d-m-Y H:i:s');
	$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from jualh where id='$_GET[id]'"));
	$id = $_GET['id'];
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
	if ($de['batal'] == 'N') {
		$batal = 'Y';
	} else {
		$batal = 'N';
	}
	$query = $connect->prepare("update jualh set batal=?, user_proses=? where id=?");
	$query->bind_param('sss', $batal, $user_proses, $id);
	// $query = $connect->prepare("delete from juald where nojual=?");
	// $query->bind_param('s',$nojual);
	// if($query->execute() and mysqli_affected_rows($connect)>0){
	// }

	// $query = $connect->prepare("delete from jualh where id=?");
	// $query->bind_param('s',$_GET['id']);
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
				window.history.back();
				// window.location.href='../../dashboard.php?m=jual&module=Penjualan';
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