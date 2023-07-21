<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	echo 'aa' . $_GET['id'];
	$query = $connect->prepare("select * from approv_batas_piutang where proses='N' and id=?");
	$query->bind_param('i', $_GET['id']);
	$result = $query->execute();
	$query->store_result();
	if ($query->num_rows == 0) {
	?>
		<script>
			swal({
				title: "Gagal hapus data, data sudah diproses",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbcustomer';
			});
		</script>
	<?php
		exit();
	}
	$query = $connect->prepare("delete from approv_batas_piutang where proses='N' and id=?");
	$query->bind_param('i', $_GET['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		// echo "<script>alert('Data berhasil dihapus !');
		// window.location.href='../../dashboard.php?m=tbcustomer';
		// </script>";
	?>
		<script>
			swal({
				title: "Data berhasil dihapus",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbcustomer';
			});
		</script>
	<?php
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.location.href='../../dashboard.php?m=tbcustomer';
		// </script>";				
	?>
		<script>
			swal({
				title: "Gagal hapus data",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbcustomer';
			});
		</script>
	<?php
	}
	//header("location:../../dashboard.php?m=tbcustomer");	
	?>
</body>