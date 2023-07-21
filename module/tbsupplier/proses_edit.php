<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	if (!empty($_POST['kode'])) {
		//proses simpan
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		$query = $connect->prepare("select * from tbsupplier where kode=? and id<>?");
		$query->bind_param('si', $_POST['kode'], $_POST['id']);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			// echo "<script>alert('Kode tersebut sudah digunakan');
			// 	window.location.href='../../dashboard.php?m=tbsupplier';
			// 	</script>";							
	?>
			<script>
				swal({
					title: "Gagal simpan data",
					text: "Kode tersebut sudah digunakan",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=tbsupplier';
				});
			</script>
		<?php
			exit();
		}
		$user_input = "Update-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$kode = trim(strip_tags($_POST['kode']));
		$nama = strip_tags($_POST['nama']);
		$alamat = strip_tags($_POST['alamat']);
		$kota = strip_tags($_POST['kota']);
		$kodepos = strip_tags($_POST['kodepos']);
		$telp1 = strip_tags($_POST['telp1']);
		$telp2 = strip_tags($_POST['telp2']);
		$npwp = strip_tags($_POST['npwp']);
		$contact_person = strip_tags($_POST['contact_person']);
		$query = $connect->prepare("update tbsupplier set kode=?,nama=?,alamat=?,kota=?,kodepos=?,telp1=?,telp2=?,npwp=?,contact_person=?,user=? where id=?");
		$query->bind_param('ssssssssssi', $kode, $nama, $alamat, $kota, $kodepos, $telp1, $telp2, $npwp, $contact_person, $user_input, $_POST['id']);

		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=tbsupplier';
			// </script>";										
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=tbsupplier';
				});
			</script>
		<?php
		} else {
			// echo "<script>alert('Gagal simpan data !');
			// window.location.href='../../dashboard.php?m=tbsupplier';
			// </script>";							
		?>
			<script>
				swal({
					title: "Gagal simpan data ",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=tbsupplier';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=tbsupplier");
	}
	?>
</body>