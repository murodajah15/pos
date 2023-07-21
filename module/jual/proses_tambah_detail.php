<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	date_default_timezone_set('Asia/Jakarta');
	$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
	$nojual = strip_tags($_POST['nojual']);
	$noso = strip_tags($_POST['noso']);
	$page = $_POST['page'];
	$kata = $_POST['kata'];
	$kdcustomer = $_POST['kdcustomer'];
	$lanjut = 1;
	if (!empty($noso)) {
		//proses simpan
		$tampil = mysqli_query($connect, "select * from sod where noso='$noso' and kurang>0");
		$cek = mysqli_num_rows($tampil);
		if ($cek == 0) {
			$lanjut = 0;
		}
		$kunci_stock = $_POST['kunci_stock'];
		if ($kunci_stock == 'Y') {
			while ($k = mysqli_fetch_assoc($tampil)) {
				$kdbarang = $k['kdbarang'];
				$cek = mysqli_fetch_assoc(mysqli_query($connect, "select kode,stock from tbbarang where kdbarang='$kdbarang'"));
				if ($k['qty'] > $cek['kurang']) {
					$lanjut = 0;
				}
			}
		}
		if ($lanjut == 0) {
	?>
			<script>
				swal({
					title: "Gagal simpan data, penjualan melebihi stock",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-1);
				});
			</script>
			<?php
			exit();
		}
		while ($k = mysqli_fetch_assoc($tampil)) {
			$kdbarang = $k['kdbarang'];
			$nmbarang = $k['nmbarang'];
			$kdsatuan = $k['kdsatuan'];
			$qty = $k['kurang'];
			$harga = $k['harga'];
			$discount = $k['discount'];
			$subtotal = $k['subtotal'];
			$subtotal = ($qty * $harga) - (($qty * $harga) * $discount / 100);
			$cek = mysqli_num_rows(mysqli_query($connect, "select noso,kdbarang from juald where noso='$noso' and kdbarang='$kdbarang' and nojual='$nojual'"));
			if ($cek > 0) {
			} else {
				$query = $connect->prepare("INSERT INTO juald (nojual,noso,kdbarang,nmbarang,kdsatuan,qty,harga,discount,subtotal,user) values (?,?,?,?,?,?,?,?,?,?)");
				$query->bind_param('ssssssssss', $nojual, $noso, $kdbarang, $nmbarang, $kdsatuan, $qty, $harga, $discount, $subtotal, $user_input);
				if ($query->execute() and mysqli_affected_rows($connect) > 0) {
				} else {
			?>
					<script>
						swal({
							title: "Gagal simpan data ",
							text: "",
							icon: "error"
						}).then(function() {
							// window.location.href = '../../dashboard.php?m=jual&tipe=detail&nojual=$nojual&kdcustomer=$kdcustomer'; //'../../dashboard.php?m=jual';
							window.location.href = '../../dashboard.php?m=jual&tipe=detail&id=$_POST[id]'; //'../../dashboard.php?m=jual';
						});
					</script>
				<?php
				}
			}
		}
	} else {
		$kdbarang = $_POST['kdbarang'];
		if (!empty($kdbarang)) {
			$cek = mysqli_num_rows(mysqli_query($connect, "select * from juald where kdbarang='$kdbarang' and nojual='$_POST[nojual]'"));
			if ($cek > 0) {
				echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$query = mysqli_query($connect, "select kode,stock from tbbarang where kode='$kdbarang'");
			$cek = mysqli_num_rows($query);
			if ($cek == 0) {
				echo "<script>alert('Kode Barang tidak ada di tabel barang, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$cekstock = mysqli_fetch_assoc($query);
			$stock = $cekstock['stock'];
			$nmbarang = $_POST['nmbarang'];
			$kdsatuan = $_POST['kdsatuan'];
			$qty = $_POST['qty'];
			$harga = $_POST['harga'];
			$discount = $_POST['discount'];
			$subtotal = $_POST['subtotal'];
			$subtotal = ($qty * $harga) - (($qty * $harga) * $discount / 100);
			$kunci_stock = $_POST['kunci_stock'];
			$id = $_POST['id'];
			if ($kunci_stock == 'Y' ? $qty > $stock : $qty == $qty) {
				?>
				<script>
					swal({
						title: "Gagal simpan data, penjualan melebihi stock",
						text: "",
						icon: "error"
					}).then(function() {
						window.history.go(-1);
					});
				</script>
				<?php
				exit();
			} else {
				$query = $connect->prepare("INSERT INTO juald (nojual,kdbarang,nmbarang,kdsatuan,qty,harga,discount,subtotal,user) values (?,?,?,?,?,?,?,?,?)");
				$query->bind_param('sssssssss', $nojual, $kdbarang, $nmbarang, $kdsatuan, $qty, $harga, $discount, $subtotal, $user_input);
				if ($query->execute() and mysqli_affected_rows($connect) <= 0) {
				?>
					<script>
						alert('Data berhasil disimpan');
					</script>
	<?php
				}
			}
			//header("location:../../dashboard.php?m=jual");
		}
	}
	$query = mysqli_query($connect, "select sum(subtotal) as nsubtotal from juald where nojual='$_POST[nojual]'");
	$k = mysqli_fetch_assoc($query);
	$subtotal = $k['nsubtotal'];
	// mysqli_query($connect, "update jualh set subtotal='$subtotal', total='$subtotal'+total_sementara+materai+(total_sementara*(ppn/100)) where nojual='$nojual'");
	mysqli_query($connect, "update jualh set subtotal=$subtotal where nojual='$_POST[nojual]'");
	mysqli_query($connect, "update jualh set total_sementara=($subtotal+biaya_lain) where nojual='$_POST[nojual]'");
	mysqli_query($connect, "update jualh set total=($subtotal+biaya_lain)+(($subtotal+biaya_lain)*(ppn/100)) where nojual='$_POST[nojual]'");
	//header("location:../../dashboard.php?m=jual&tipe=detail&nojual=$nojual&kata=$kata&page=$page");
	// header("location:../../dashboard.php?m=jual&tipe=detail&nojual=$nojual&kdcustomer=$kdcustomer");
	header("location:../../dashboard.php?m=jual&tipe=detail&id=$_POST[id]");
	?>
</body>