<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	//proses hapus
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$query = mysqli_query($connect, "select * from kasir_tunai where id='$_GET[id]'");
	$de = mysqli_fetch_assoc($query);
	$bayar = $de['bayar'];
	$nojual = $de['nojual'];
	$tglkwitansi = $de['tglkwitansi'];

	$query = mysqli_query($connect, "select kurangbayar from jualh where nojual='$nojual'");
	$k = mysqli_fetch_assoc($query);
	$kurangbayar = $k['kurangbayar'];
	if ($bayar > $kurangbayar) {
		$text = "Nilai Pembayaran melebihi nilai piutang Dokumen " . $nojual . " !";
	?>
		<script>
			swal({
				title: "Gagal proses data",
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

	$tampil = mysqli_query($connect, "select * from kasir_tunai where id='$_GET[id]'");
	$de = mysqli_fetch_assoc($tampil);
	$nokwitansi = $de['nokwitansi'];
	if ($de['proses'] == 'Y') {
		$text = "Dokumen " . $nokwitansi . " Sudah di proses !";
	?>
		<script>
			swal({
				title: "Gagal proses data",
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

	$user = $_SESSION['username'];
	$user_proses = "Proses-" . $user . "-" . date('d-m-Y H:i:s');
	$proses = 'Y';
	$query = $connect->prepare("update kasir_tunai set proses=?,user_proses=? where id=?");
	$query->bind_param('ssi', $proses, $user_proses, $_GET['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		mysqli_query($connect, "update jualh set sudahbayar=sudahbayar+'$bayar',kurangbayar=total-sudahbayar where nojual='$nojual'")
	?>
		<script>
			swal({
				title: "Data berhasil diproses",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tunai';
			});
		</script>
	<?php
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.location.href='../../dashboard.php?m=tbbank';
		// </script>";				
	?>
		<script>
			swal({
				title: "Gagal proses data",
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