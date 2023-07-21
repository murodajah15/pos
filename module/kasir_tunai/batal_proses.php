<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	//proses hapus
	session_start();
	date_default_timezone_set('Asia/Jakarta');

	$tampil = mysqli_query($connect, "select * from kasir_tunai where id='$_POST[id]'");
	$de = mysqli_fetch_assoc($tampil);
	$nokwitansi = $de['nokwitansi'];
	$tglkwitansi = $de['tglkwitansi'];
	if ($de['proses'] == 'N') {
		$text = "Dokumen " . $nokwitansi . " Sudah di batal proses !";
	?>
		<script>
			swal({
				title: "Gagal batal proses data",
				text: "<?= $text ?>",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tunai';
			});
		</script>
	<?php
		$lanjut = 0;
		exit();
	}

	$cek = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
	$closing_hpp = $cek['closing_hpp'];
	$bulan = substr($tglkwitansi, 5, 2);
	$tahun = substr($tglkwitansi, 0, 4);
	$periode = $tahun . $bulan;
	//echo $periode;
	if ($periode <= $closing_hpp) {
		echo 'Closing terakhir : ' . $closing_hpp;
	?>
		<script>
			swal({
				title: "Gagal Proses !",
				text: "Sudah Closing Data Bulanan !",
				icon: "success"
			}).then(function() {
				window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
			});
		</script>
	<?php
		exit();
	}

	$user = $_SESSION['username'];
	$user_proses = "Batal Proses-" . $user . "-" . date('d-m-Y H:i:s');
	$tglselesai = date('');
	$proses = 'N';
	$query = $connect->prepare("update kasir_tunai set proses=?,user_proses=? where id=?");
	$query->bind_param('ssi', $proses, $user_proses, $_POST['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		$query = mysqli_query($connect, "select * from kasir_tunai where id='$_POST[id]'");
		$de = mysqli_fetch_assoc($query);
		$bayar = $de['bayar'];
		$nojual = $de['nojual'];
		mysqli_query($connect, "update jualh set sudahbayar=sudahbayar-'$bayar',kurangbayar=total-sudahbayar where nojual='$nojual'")
	?>
		<script>
			swal({
				title: "Data berhasil di Batal Proses",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tunai';
			});
		</script>
	<?php
		//Create History
		$tanggal = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');
		$dokumen = $nokwitansi;
		$form = 'Kasir Tunai';
		$status = 'Batal Proses';
		$catatan = $_POST['catatan'];
		$username = $_SESSION['username'];
		$history = $connect->prepare("insert into hisuser (tanggal,dokumen,form,status,user,catatan,datetime) values (?,?,?,?,?,?,?)");
		$history->bind_param('sssssss', $tanggal, $dokumen, $form, $status, $username, $catatan, $datetime);
		$history->execute();
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
		// </script>";				
	?>
		<script>
			swal({
				title: "Gagal Batal Proses data",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tunai';
			});
		</script>
	<?php
	}
	?>
</body>