<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	//proses hapus
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$query = mysqli_query($connect, "select * from kasir_tagihan where id='$_GET[id]'");
	$de = mysqli_fetch_assoc($query);
	$bayar = $de['bayar'];
	$nojual = $de['nojual'];
	$nokwitansi = $de['nokwitansi'];
	$tglkwitansi = $de['tglkwitansi'];
	$total = $de['total'];

	$lanjut = 'Y';

	if ($total <= 0) {
		$lanjut = 'N';
	?>
		<script>
			swal({
				title: "Gagal proses data",
				text: "Nilai bayar masih kosong",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tagihan';
			});
		</script>
		<?php
		exit();
	}
	//Ceh dulu nilai bayar, lebih besar piutang atau tidak

	$query = mysqli_query($connect, "select * from kasir_tagihand where nokwitansi='$nokwitansi'");
	while ($k = mysqli_fetch_assoc($query)) {
		$nojual = $k['nojual'];
		$bayar = $k['bayar'];
		$querycek = mysqli_query($connect, "select * from jualh where nojual='$nojual' and kurangbayar<'$bayar'");
		$k = mysqli_fetch_assoc($query);
		if (mysqli_num_rows($querycek) > 0) {
		?>
			<script>
				$text = "Penjualan sudah lunas " + $nojual + " !";
				swal({
					title: "Gagal proses data",
					text: "<?= $text ?>",
					icon: "error"
				}).then(function() {
					window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tagihan';
				});
			</script>
		<?php
			$lanjut = 'N';
			break;
		}
	}

	if ($lanjut == "N") {
		?>
		<script>
			$text = "Nilai Pembayaran melebihi nilai piutang Dokumen " + $nojual + " !";
			swal({
				title: "Gagal proses data",
				text: "<?= $text ?>",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tagihan';
			});
		</script>
		<?php
	} else {
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

		$tampil = mysqli_query($connect, "select * from kasir_tagihan where id='$_GET[id]'");
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
					window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tagihan';
				});
			</script>
		<?php
			$lanjut = 0;
			exit();
		}

		$user = $_SESSION['username'];
		$user_proses = "Proses-" . $user . "-" . date('d-m-Y H:i:s');
		$proses = 'Y';
		$query = $connect->prepare("update kasir_tagihan set proses=?,user_proses=? where id=?");
		$query->bind_param('ssi', $proses, $user_proses, $_GET['id']);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			$queryupdate = mysqli_query($connect, "select * from kasir_tagihand where nokwitansi='$nokwitansi'");
			while ($k = mysqli_fetch_assoc($queryupdate)) {
				$nojual = $k['nojual'];
				$bayar = $k['bayar'];
				mysqli_query($connect, "update jualh set sudahbayar=sudahbayar+'$bayar',kurangbayar=total-sudahbayar where nojual='$nojual'");
			}
		?>
			<script>
				swal({
					title: "Data berhasil diproses",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tagihan';
				});
			</script>
		<?php
		} else {
			// echo "<script>alert('Gagal hapus data !');
			// window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
			// </script>";				
		?>
			<script>
				swal({
					title: "Gagal proses data",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.back(); //window.location.href='../../dashboard.php?m=kasir_tagihan';
				});
			</script>
	<?php
		}
	}
	?>

</body>