<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	$query = mysqli_query($connect, "select * from tbsupplier where id='$_GET[id]'");
	$row = mysqli_fetch_array($query);
	$kdsupplier = $row['kode'];
	$query = $connect->prepare("select * from poh where kdsupplier=?");
	$query->bind_param('s', $kdsupplier);
	$result = $query->execute();
	$query->store_result();
	if ($query->num_rows >= "1") {
	?>
		<script>
			swal({
				title: "Gagal dihapus",
				text: "Sudah terpakai ditransaksi",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
			});
		</script>
	<?php
		exit();
	}
	$query = $connect->prepare("delete from tbsupplier where id=?");
	$query->bind_param('i', $_GET['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
	?>
		<script>
			swal({
				title: "Data berhasil dihapus",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
			});
		</script>
	<?php
	} else {
	?>
		<script>
			swal({
				title: "Gagal hapus data",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
			});
		</script>
	<?php
	}
	//header("location:../../dashboard.php?m=tbsupplier");	
	?>
</body>