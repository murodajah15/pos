<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	$user = $_SESSION['username'];
	$user_proses = "Proses-" . $user . "-" . date('d-m-Y H:i:s');
	$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from poh where id='$_GET[id]'"));
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
	// $query = mysqli_query($connect, "select * from poh where id=$_GET[id]");
	// $de = mysqli_fetch_assoc($query);
	// $nopo = $de['nopo'];
	// $query = $connect->prepare("delete from pod where nopo=?");
	// $query->bind_param('s',$nopo);
	// if($query->execute() and mysqli_affected_rows($connect)>0){
	// }

	// $query = $connect->prepare("delete from poh where id=?");
	// $query->bind_param('i',$_GET['id']);
	if ($de['batal'] == 'N') {
		$batal = 'Y';
		// $query = $connect->prepare("update poh set batal=? where nopo=?");
		// $query->bind_param('ss', $batal, $nojual);
	} else {
		$batal = 'N';
		// $query = $connect->prepare("update poh set batal=? where nopo=?");
		// $query->bind_param('ss', $batal, $nojual);
	}
	$query = $connect->prepare("update poh set batal=?, user_proses=? where id=?");
	$query->bind_param('sss', $batal, $user_proses, $id);
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