<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	if (!empty($_POST['kd_perusahaan'])) {
		//proses simpan
		include "../../inc/config.php";
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		// $cek = mysqli_num_rows(mysqli_query($connect,"select * from saplikasi where kd_perusahaan='$_POST[kd_perusahaan]'"));
		// if ($cek > 0){
		// 	echo "<script>alert('Kode sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
		// 	exit();
		// }
		// $user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
		/*$query = mysqli_query($connect,"insert into saplikasi (kd_perusahaan,nm_perusahaan,alamat,npwp,aktif,user) values 
			('$_POST[kd_perusahaan]','$_POST[nm_perusahaan]','$_POST[alamat]','$_POST[npwp]','$_POST[aktif]','$user')");	
			if($query){
				header("location:../../dashboard.php?m=saplikasi");**/
		$query = $connect->prepare("select * from saplikasi where kd_perusahaan=?");
		$query->bind_param('s', $_POST['kd_perusahaan']);
		$result = $query->execute();
		$query->store_result();
		if ($query->num_rows >= "1") {
			/*echo "<script>alert('Kode tersebut sudah digunakan');
					window.location.href='../../dashboard.php?m=saplikasi';
					</script>";**/
	?>
			<script>
				swal({
					title: "Kode tersebut sudah digunakan!",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-1); //window.location.href='../../dashboard.php?m=tbgolongan';
				});
			</script>
		<?php
			exit();
		}
		$logo = upload();
		$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$query = $connect->prepare("INSERT INTO saplikasi (kd_perusahaan,nm_perusahaan,alamat,telp,npwp,jenis_hpp,direktur,finance_mgr,aktif,user,logo,dirbackup,kunci_harga_jual,norek1,norek2,kunci_stock) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$query->bind_param(
			'ssssssssssssssss',
			$_POST['kd_perusahaan'],
			$_POST['nm_perusahaan'],
			$_POST['alamat'],
			$_POST['telp'],
			$_POST['npwp'],
			$_POST['jenis_hpp'],
			$_POST['direktur'],
			$_POST['finance_mgr'],
			$_POST['aktif'],
			$user_input,
			$logo,
			$_POST['dirbackup'],
			$_POST['kunci_harga_jual'],
			$_POST['norek1'],
			$_POST['norek2'],
			$_POST['kunci_stock']
		);

		// if($query->execute()){
		// 	echo "<script>alert('Data berhasil disimpan !');
		// 	window.location.href='../../dashboard.php?m=saplikasi';
		// 	</script>";							
		// }else{
		// 	echo "<script>alert('Gagal simpan data !');
		// 	window.location.href='../../dashboard.php?m=saplikasi';
		// 	</script>";							
		// }
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=tbgolongan';
			// </script>";							
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=saplikasi';
				});
			</script>
		<?php
		} else {
			// echo "<script>alert('Gagal simpan data !');
			// window.location.href='../../dashboard.php?m=tbgolongan';
			// </script>";							
		?>
			<script>
				swal({
					title: "Gagal simpan data ",
					text: "",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=saplikasi';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=saplikasi");
	}
	?>

	<?php
	function upload()
	{
		$namaFile = $_FILES['logo']['name'];
		$ukuranFile = $_FILES['logo']['size'];
		$error = $_FILES['logo']['error'];
		$tmpName = $_FILES['logo']['tmp_name'];

		// cek apakah tidak ada logo yang diupload
		if ($error === 4) {
			echo "<script>
						alert('pilih logo!');
					  </script>";
			return false;
		}

		// cek apakah yang diupload adalah logo
		$ekstensilogoValid = ['jpg', 'jpeg', 'png', 'bmp', 'tiff'];
		$ekstensilogo = explode('.', $namaFile);
		$ekstensilogo = strtolower(end($ekstensilogo));
		if (!in_array($ekstensilogo, $ekstensilogoValid)) {
			echo "<script>
					alert('Pilihlah File logo!');
				  </script>";
			return false;
		}

		// cek jika ukurannya terlalu besar
		if ($ukuranFile > 4000000) {
			echo "<script>
					alert('Ukuran logo Terlalu Besar!');
				  </script>";
			return false;
		}

		// lolos pengecekan, logo siap diupload
		// generate nama logo baru
		$namaFileBaru = uniqid();
		$namaFileBaru .= '.';
		$namaFileBaru .= $ekstensilogo;

		echo $namaFileBaru;
		$dir = '../../img/';
		if (is_dir($dir)) {
			move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);
		} else {
			move_uploaded_file($tmpName, '/../img/' . $namaFileBaru);
		}
		return $namaFileBaru;
	}
	?>

</body>