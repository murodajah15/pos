<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
	$id = strip_tags($_POST['id']);
	$nobeli = strip_tags($_POST['nobeli']);
	if (!empty($_POST['nobeli'])) {
		//proses simpan
		include "../../inc/config.php";
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		$nopo = strip_tags($_POST['nopo']);
		echo $nopo;
		if (!empty($_POST['nopo'])) {
			$tampil = mysqli_query($connect, "select * from pod where nopo='$nopo' and kurang>0");
			while ($k = mysqli_fetch_assoc($tampil)) {
				$kdbarang = $k['kdbarang'];
				$nmbarang = $k['nmbarang'];
				$kdsatuan = $k['kdsatuan'];
				$qty = $k['kurang'];
				$harga = $k['harga'];
				$discount = $k['discount'];
				$subtotal = $k['subtotal'];
				$subtotal = ($qty * $harga) - (($qty * $harga) * $discount / 100);
				$cek = mysqli_num_rows(mysqli_query($connect, "select nopo,kdbarang from belid where nopo='$nopo' and kdbarang='$kdbarang' and nobeli='$nobeli'"));
				if ($cek == 0) {
					$query = $connect->prepare("INSERT INTO belid (nobeli,nopo,kdbarang,nmbarang,kdsatuan,qty,harga,discount,subtotal,user) values (?,?,?,?,?,?,?,?,?,?)");
					$query->bind_param('ssssssssss', $nobeli, $nopo, $kdbarang, $nmbarang, $kdsatuan, $qty, $harga, $discount, $subtotal, $user_input);
					if ($query->execute() and mysqli_affected_rows($connect) > 0) {
					}
				} else {
					$query = $connect->prepare("update belid set nobeli=?,nopo=?,kdbarang=?,nmbarang=?,kdsatuan=?,qty=?,harga=?,discount=?,subtotal=?,user=? where nopo=? and kdbarang=? and nobeli=?");
					$query->bind_param('sssssssssssss', $nobeli, $nopo, $kdbarang, $nmbarang, $kdsatuan, $qty, $harga, $discount, $subtotal, $user_input, $nopo, $kdbarang, $nobeli);
					if ($query->execute() and mysqli_affected_rows($connect) > 0) {
					}
				}
			}
		} else {
			if ($_POST['kdbarang'] == "") {
	?>
				<script>
					swal({
						title: "Gagal simpan data ",
						text: "",
						icon: "error"
					}).then(function() {
						window.location.href = '../../dashboard.php?m=beli&tipe=detail&nobeli=$nobeli';
					});
				</script>
			<?php
				exit();
			}
			$nobeli = strip_tags($_POST['nobeli']);
			$kdbarang = $_POST['kdbarang'];
			$nmbarang = $_POST['nmbarang'];
			$qty = $_POST['qty'];
			$harga = $_POST['harga'];
			$discount = $_POST['discount'];
			$subtotal = $_POST['subtotal'];
			$subtotal = ($qty * $harga) - (($qty * $harga) * $discount / 100);
			$query = $connect->prepare("INSERT INTO belid (nobeli,kdbarang,nmbarang,qty,harga,discount,subtotal,user) values (?,?,?,?,?,?,?,?)");
			$query->bind_param('ssssssss', $nobeli, $kdbarang, $nmbarang, $qty, $harga, $discount, $subtotal, $user_input);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			?>
				<script>
					swal({
						title: "Data Berhasil disimpan ",
						text: "",
						icon: "success"
					}).then(function() {
						window.location.href = '../../dashboard.php?m=beli&tipe=detail&nobeli=$nobeli';
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
						window.location.href = '../../dashboard.php?m=beli&tipe=detail&nobeli=$nobeli';
					});
				</script>
	<?php
			}
			//header("location:../../dashboard.php?m=jual");
		}
		$query = mysqli_query($connect, "select sum(subtotal) as nsubtotal from belid where nobeli='$_POST[nobeli]'");
		$k = mysqli_fetch_assoc($query);
		$subtotal = $k['nsubtotal'];
		echo $subtotal;
		mysqli_query($connect, "update belih set subtotal='$subtotal', total='$subtotal'+total_sementara+materai+(total_sementara*(ppn/100)) where nobeli='$_POST[nobeli]'");
		// header("location:../../dashboard.php?m=beli&tipe=detail&nobeli=$nobeli");
		header("location:../../dashboard.php?m=beli&tipe=detail&id=$id");
	} else {
		header("location:../../dashboard.php?m=beli");
	}
	?>
</body>