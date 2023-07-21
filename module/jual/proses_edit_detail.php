<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	if (!empty($_POST['kdbarang'])) {
		//proses simpan
		date_default_timezone_set('Asia/Jakarta');
		$query = mysqli_query($connect, "select * from sod where kdbarang='$_POST[kdbarang]' and noso='$_POST[noso]'");
		$rec = mysqli_num_rows($query);
		if ($rec > 0) {
			$de = mysqli_fetch_assoc($query);
			$kurang = $de['kurang'];
			if ($kurang < $_POST['qty']) {
				echo "<script>alert('QTY Penjualan tidak boleh lebih dari sisa Pesanan');history.go(-1) </script>";
				exit();
			}
		}
		$user_input = "Update-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$qty = $_POST['qty'];
		$harga = $_POST['harga'];
		$discount = $_POST['discount'];
		$subtotal = $_POST['subtotal'];
		$subtotal = ($qty * $harga) - (($qty * $harga) * ($discount / 100));
		$query = $connect->prepare("update juald set qty=?,harga=?,discount=?,subtotal=?,user=? where id=?");
		$query->bind_param('ssssss', $qty, $harga, $discount, $subtotal, $user_input, $_POST['id']);
		if ($query->execute()) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";													
			// $query = $connect->prepare("update juald set qty=?,harga=?,discount=?,subtotal=?,user=? where id=?");
			// $query->bind_param('ssssss', $qty, $harga, $discount, $subtotal, $user_input, $_POST['id']);

			$query = mysqli_query($connect, "select sum(subtotal) as nsubtotal from juald where nojual='$_POST[nojual]'");
			$k = mysqli_fetch_assoc($query);
			$total = $k['nsubtotal'];
			// mysqli_query($connect, "update jualh set subtotal='$total', total=$total+($total*(ppn/100)) where nojual='$_POST[nojual]'");
			mysqli_query($connect, "update jualh set subtotal=$total where nojual='$_POST[nojual]'");
			mysqli_query($connect, "update jualh set total_sementara=($total+biaya_lain) where nojual='$_POST[nojual]'");
			mysqli_query($connect, "update jualh set total=($total+biaya_lain)+(($total+biaya_lain)*(ppn/100)) where nojual='$_POST[nojual]'");
	?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=order_part';
				});
			</script>
		<?php
		} else {
			// echo "<script>alert('Gagal simpan data !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";							
		?>
			<script>
				swal({
					title: "Gagal simpan data ",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-1); //then(function(){window.location.href='../../dashboard.php?m=order_part';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=jual");
	}
	?>
</body>