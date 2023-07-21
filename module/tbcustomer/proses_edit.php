<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	if (!empty($_POST['kode'])) {
		//proses simpan
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		$query = $connect->prepare("select * from tbcustomer where kode=? and id<>?");
		$query->bind_param('si', $_POST['kode'], $_POST['id']);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			// echo "<script>alert('Kode tersebut sudah digunakan');
			// 	window.location.href='../../dashboard.php?m=tbcustomer';
			// 	</script>";							
	?>
			<script>
				swal({
					title: "Gagal simpan data",
					text: "Kode tersebut sudah digunakan",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=tbcustomer';
				});
			</script>
		<?php
			exit();
		}
		$user_input = "Update-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$kode = trim(strip_tags($_POST['kode']));
		$kelompok = strip_tags($_POST['kelompok']);
		$nama = strip_tags($_POST['nama']);
		$alamat = strip_tags($_POST['alamat']);
		$kota = strip_tags($_POST['kota']);
		$kodepos = strip_tags($_POST['kodepos']);
		$telp1 = strip_tags($_POST['telp1']);
		$telp2 = strip_tags($_POST['telp2']);
		$agama = strip_tags($_POST['agama']);
		$tgl_lahir = strip_tags($_POST['tgl_lahir']);
		$alamat_ktr = strip_tags($_POST['alamat_ktr']);
		$kota_ktr = strip_tags($_POST['kota_ktr']);
		$kodepos_ktr = strip_tags($_POST['kodepos_ktr']);
		$telp1_ktr = strip_tags($_POST['telp1_ktr']);
		$telp2_ktr = strip_tags($_POST['telp2_ktr']);
		$npwp = strip_tags($_POST['npwp']);
		$alamat_npwp = strip_tags($_POST['alamat_npwp']);
		$nama_npwp = strip_tags($_POST['nama_npwp']);
		$alamat_ktp = strip_tags($_POST['alamat_ktp']);
		$kota_ktp = strip_tags($_POST['kota_ktp']);
		$kodepos_ktp = strip_tags($_POST['kodepos_ktp']);
		$tgl_register = date('Y-m-d');
		$mak_piutang = strip_tags($_POST['mak_piutang']);

		$query = $connect->prepare("update tbcustomer set kode=?,kelompok=?,nama=?,alamat=?,kota=?,kodepos=?,telp1=?,telp2=?,agama=?,tgl_lahir=?,alamat_ktr=?,kota_ktr=?,kodepos_ktr=?,telp1_ktr=?,telp2_ktr=?,npwp=?,alamat_npwp=?,nama_npwp=?,alamat_ktp=?,kota_ktp=?,kodepos_ktp=?,tgl_register=?,user=?,mak_piutang=? where id=?");
		$query->bind_param('sssssssssssssssssssssssii', $kode, $kelompok, $nama, $alamat, $kota, $kodepos, $telp1, $telp2, $agama, $tgl_lahir, $alamat_ktr, $kota_ktr, $kodepos_ktr, $telp1_ktr, $telp2_ktr, $npwp, $alamat_npwp, $nama_npwp, $alamat_ktp, $kota_ktp, $kodepos_ktp, $tgl_register, $user_input, $mak_piutang, $_POST['id']);

		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=tbcustomer';
			// </script>";										
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=tbcustomer';
				});
			</script>
		<?php
		} else {
			// echo "<script>alert('Gagal simpan data !');
			// window.location.href='../../dashboard.php?m=tbcustomer';
			// </script>";							
		?>
			<script>
				swal({
					title: "Gagal simpan data ",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=tbcustomer';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=tbcustomer");
	}
	?>
</body>