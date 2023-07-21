<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from belih where id='$_GET[id]'"));
	$nobeli = $de['nobeli'];
	if ($de['proses'] == 'Y') {
	?>
		<script>
			swal({
				title: "Data sudah diproses, tidak bisa Hapus Data",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=beli';
			});
		</script>
	<?php
		exit();
	}
	// $query = $connect->prepare("delete from belid where nobeli=?");
	// $query->bind_param('s',$nobeli);
	// if($query->execute() and mysqli_affected_rows($connect)>0){
	// }
	// $query = $connect->prepare("delete from belih where id=?");
	// $query->bind_param('s',$_GET['id']);
	if ($de['batal'] == 'N') {
		$batal = 'Y';
		$query = $connect->prepare("update belih set batal=? where nobeli=?");
		$query->bind_param('ss', $batal, $noso);
	} else {
		$batal = 'N';
		$query = $connect->prepare("update belih set batal=? where nobeli=?");
		$query->bind_param('ss', $batal, $noso);
	}
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		// echo "<script>alert('Data berhasil dihapus !');
		// window.location.href='../../dashboard.php?m=wo';
		// </script>";
	?>
		<script>
			swal({
				title: "Data berhasil dihapus",
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
				title: "Gagal hapus data",
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