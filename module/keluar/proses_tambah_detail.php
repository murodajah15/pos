<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	if (!empty($_POST['nokeluar'])) {
		//proses simpan
		include "../../inc/config.php";
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		$kdbarang = strip_tags($_POST['kdbarang']);
		$cek = mysqli_num_rows(mysqli_query($connect, "select * from keluard where kdbarang='$kdbarang' and nokeluar='$_POST[nokeluar]'"));
		if ($cek > 0) {
			echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
			exit();
		}
		$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$nokeluar = strip_tags($_POST['nokeluar']);
		$kdbarang = strip_tags($_POST['kdbarang']);
		$nmbarang = strip_tags($_POST['nmbarang']);
		$qty = $_POST['qty'];
		$harga = $_POST['harga'];
		$subtotal = ($qty * $harga);

		$query = mysqli_query($connect, "select kode,stock,kdsatuan from tbbarang where kode='$kdbarang'");
		$de = mysqli_fetch_assoc($query);
		$kdsatuan = strip_tags($de['kdsatuan']);
		$stock = strip_tags($de['stock']);

		$kunci_stock = $_POST['kunci_stock'];
		if ($kunci_stock == 'Y' ? $qty > $stock : $qty == $qty) {
	?>
			<script>
				swal({
					title: "Gagal simpan data, pengeluaran melebihi stock",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-1);
				});
			</script>
		<?php
			exit();
		}

		$query = $connect->prepare("INSERT INTO keluard (nokeluar,kdbarang,nmbarang,kdsatuan,qty,harga,subtotal,user) values (?,?,?,?,?,?,?,?)");
		$query->bind_param('ssssssss', $nokeluar, $kdbarang, $nmbarang, $kdsatuan, $qty, $harga, $subtotal, $user_input);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			$tampil = mysqli_query($connect, "select * from keluarh where nokeluar='$nokeluar'");
			$de = mysqli_fetch_assoc($tampil);
			$nokeluar = $de['nokeluar'];
			$nsubtotal = hit_total($connect, $nokeluar);
			$ntotal = $de['biaya_lain'] + $nsubtotal;
			$query = $connect->prepare("update keluarh set subtotal=?,total=? where nokeluar=?");
			$query->bind_param('iis', $nsubtotal, $ntotal, $nokeluar);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			}
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
				});
			</script>
		<?php
		} else {
		?>
			<script>
				swal({
					title: "Gagal simpan data ",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=keluar");
	}
	?>

	<script>
		<?php
		//pembuatan fungsi
		function hit_total($connect, $nokeluar)
		{
			global $nsubtotal;
			include "../../inc/config.php";
			$tampil = mysqli_query($connect, "select sum(subtotal) as nsubtotal from keluard where nokeluar='$nokeluar'");
			$de = mysqli_fetch_assoc($tampil);
			$nsubtotal = $de['nsubtotal'];
			//$nppn = $nsubtotal * ($ppn/100);
			//$ntotal = $nsubtotal - $nppn;
			return $nsubtotal;
		}
		?>
	</script>

</body>