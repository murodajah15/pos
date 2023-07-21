<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	date_default_timezone_set('Asia/Jakarta');
	$id = $_POST['id'];
	$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
	$nokwitansi = strip_tags($_POST['nokwitansi']);
	$nomohon = strip_tags($_POST['nomohon']);
	$tglkwitansi = $_POST['tglkwitansi'];
	if (!empty($_POST['nomohon'])) {
		//proses simpan
		$tampil = mysqli_query($connect, "select * from mohklruangd where nomohon='$nomohon' and kurang>0");
		while ($k = mysqli_fetch_assoc($tampil)) {
			$nodokumen = $k['nodokumen'];
			$uang = $k['uang'];
			$kdsupplier = $k['kdsupplier'];
			$nmsupplier = $k['nmsupplier'];
			$keterangan = $k['keterangan'];
			$cek = mysqli_num_rows(mysqli_query($connect, "select nokwitansi,nodokumen from kasir_keluard where nodokumen='$nodokumen' and nokwitansi='$nokwitansi' and keterangan='$keterangan' and nmsupplier='$nmsupplier'"));
			if ($cek > 0) {
			} else {
				$query = $connect->prepare("INSERT INTO kasir_keluard (nomohon,nokwitansi,nodokumen,tgldokumen,kdsupplier,nmsupplier,keterangan,uang,user) values (?,?,?,?,?,?,?,?,?)");
				$query->bind_param('sssssssss', $nomohon, $nokwitansi, $nodokumen, $tglkwitansi, $kdsupplier, $nmsupplier, $keterangan, $uang, $user_input);
				if ($query->execute() and mysqli_affected_rows($connect) > 0) {
				}
			}
		}
	} else {
		if (empty($_POST['keterangan']) or $_POST['uang'] <= 0) {
			echo "<script>alert('Keterangan dan Nilai tidak boleh kosong, data tidak bisa disimpan !');history.go(-1) </script>";
			exit();
		} else {
			$uang = $_POST['uang'];
			$nmsupplier = $_POST['nmsupplier'];
			$keterangan = $_POST['keterangan'];
			$nodokumen = $_POST['nodokumen'];
			$query = $connect->prepare("INSERT INTO kasir_keluard (nokwitansi,nodokumen,nmsupplier,tgldokumen,keterangan,uang,user) values (?,?,?,?,?,?,?)");
			$query->bind_param('sssssss', $nokwitansi, $nodokumen, $nmsupplier, $tglkwitansi, $keterangan, $uang, $user_input);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			}
		}
	}
	$query = mysqli_query($connect, "select sum(uang) as nsubtotal from kasir_keluard where nokwitansi='$_POST[nokwitansi]'");
	$k = mysqli_fetch_assoc($query);
	$subtotal = $k['nsubtotal'];
	mysqli_query($connect, "update kasir_keluarh set subtotal='$subtotal', total='$subtotal'+materai where nokwitansi='$nokwitansi'");
	// header("location:../../dashboard.php?m=kasir_keluar&tipe=detail&nokwitansi=$nokwitansi");
	header("location:../../dashboard.php?m=kasir_keluar&tipe=detail&id=$id");
	?>
</body>