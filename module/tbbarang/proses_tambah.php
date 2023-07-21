<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	if (!empty($_POST['nama'])) {
		/*proses simpan**/
		include "../../inc/config.php";
		date_default_timezone_set('Asia/Jakarta');
		$query = $connect->prepare("select * from tbbarang where kode=?");
		$query->bind_param('s', $_POST['kode']);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			// echo "<script>alert('Kode tersebut sudah digunakan');
			// 	window.location.href='../../dashboard.php?m=tbbarang';
			// 	</script>";							
	?>
			<script>
				swal({
					title: "Gagal simpan data !",
					text: "Kode tersebut sudah digunakan",
					icon: "error"
				}).then(function() {
						window.history.go(-1);
					} //{window.location.href='../../dashboard.php?m=tbbarang';
					//}
				);
			</script>
		<?php
			exit();
		}
		$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$kode = str_replace('"', "''", strip_tags($_POST['kode'])); //ganti kutip ke petik 2
		$nama = str_replace('"', "''", strip_tags($_POST['nama'])); //ganti kutip ke petik 2
		if (stripos($kode, '"') or strpos($nama, '"')) {
		?>
			<script>
				swal({
					title: "Gagal simpan data !",
					text: "Kode/Nama tidak boleh mengandung kutip",
					icon: "error"
				}).then(function() {
						window.history.go(-1);
					} //{window.location.href='../../dashboard.php?m=tbbarang';
					//}
				);
			</script>
		<?php
			exit();
		}
		$merek = strip_tags($_POST['merek']);
		$harga_jual = strip_tags($_POST['harga_jual']);
		$harga_beli = strip_tags($_POST['harga_beli']);
		$hpp = strip_tags($_POST['hpp']);
		$stock = strip_tags($_POST['stock']);
		$stock_min = strip_tags($_POST['stock_min']);
		$stock_mak = strip_tags($_POST['stock_mak']);
		$kdjnbrg = strip_tags($_POST['kdjnbrg']);
		$kdsatuan = strip_tags($_POST['kdsatuan']);
		$kdnegara = strip_tags($_POST['kdnegara']);
		$kdmove = strip_tags($_POST['kdmove']);
		$kddiscount  = strip_tags($_POST['kddiscount']);
		$lokasi = strip_tags($_POST['lokasi']);
		$query = $connect->prepare("INSERT INTO tbbarang (kode,nama,merek,harga_jual,harga_beli,hpp,stock,stock_min,stock_mak,kdjnbrg,kdsatuan,kdnegara,kdmove,kddiscount,user,lokasi) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$query->bind_param('ssssssssssssssss', $kode, $nama, $merek, $harga_jual, $harga_beli, $hpp, $stock, $stock_min, $stock_mak, $kdjnbrg, $kdsatuan, $kdnegara, $kdmove, $kddiscount, $user_input, $lokasi);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=tbbarang';
			// </script>";							
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=tbbarang';
				});
			</script>
		<?php
		} else {
			// echo "<script>alert('Gagal simpan data !');
			// window.location.href='../../dashboard.php?m=tbbarang';
			// </script>";							
		?>
			<script>
				swal({
					title: "Gagal simpan data !",
					text: "",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=tbbarang';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=tbbarang");
	}
	?>
</body>