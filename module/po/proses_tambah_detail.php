<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	if (!empty($_POST['nopo'])) {
		//proses simpan
		include "../../inc/config.php";
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		$kdbarang = strip_tags($_POST['kdbarang']);
		$cek = mysqli_num_rows(mysqli_query($connect, "select * from pod where kdbarang='$kdbarang' and nopo='$_POST[nopo]'"));
		if ($cek > 0) {
			echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
			exit();
		}
		$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$nopo = strip_tags($_POST['nopo']);
		$kdbarang = strip_tags($_POST['kdbarang']);
		$nmbarang = strip_tags($_POST['nmbarang']);
		$qty = $_POST['qty'];
		$harga = $_POST['harga'];
		$discount = $_POST['discount'];
		$subtotal = $_POST['subtotal'];
		$subtotal = ($qty * $harga) - (($qty * $harga) * $discount / 100);

		$query = mysqli_query($connect, "select kode,kdsatuan from tbbarang where kode='$kdbarang'");
		$de = mysqli_fetch_assoc($query);
		$kdsatuan = strip_tags($de['kdsatuan']);

		$query = $connect->prepare("INSERT INTO pod (nopo,kdbarang,nmbarang,kdsatuan,qty,harga,discount,subtotal,user) values (?,?,?,?,?,?,?,?,?)");
		$query->bind_param('sssssssss', $nopo, $kdbarang, $nmbarang, $kdsatuan, $qty, $harga, $discount, $subtotal, $user_input);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			$tampil = mysqli_query($connect, "select * from poh where nopo='$nopo'");
			$de = mysqli_fetch_assoc($tampil);
			$ppn = $de['ppn'];
			$nopo = $de['nopo'];
			$materai = $de['materai'];
			$ntotal = hit_total($connect, $nopo, $ppn);
			$total_sementara = $de['biaya_lain'] + $nsubtotal;
			$ntotal = $total_sementara + ($total_sementara * ($ppn / 100)) + $materai;
			$query = $connect->prepare("update poh set subtotal=?,total=?,total_sementara=? where nopo=?");
			$query->bind_param('ssss', $nsubtotal, $ntotal, $total_sementara, $nopo);
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
		header("location:../../dashboard.php?m=po");
	}
	?>

	<script>
		<?php
		//pembuatan fungsi
		function hit_total($connect, $nopo, $ppn)
		{
			global $nsubtotal;
			include "../../inc/config.php";
			$tampil = mysqli_query($connect, "select sum(subtotal) as nsubtotal from pod where nopo='$nopo'");
			$de = mysqli_fetch_assoc($tampil);
			$nsubtotal = $de['nsubtotal'];
			//$nppn = $nsubtotal * ($ppn/100);
			//$ntotal = $nsubtotal - $nppn;
			return $nsubtotal;
		}
		?>
	</script>

</body>