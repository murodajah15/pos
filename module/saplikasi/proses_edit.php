<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	if (!empty($_POST['kd_perusahaan'])) {
		//proses simpan
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		// $cek = mysqli_num_rows(mysqli_query($connect,"select * from saplikasi where kd_perusahaan='$_POST[kd_perusahaan]' and id<>'$_POST[id]'"));
		// if ($cek > 0){
		// 	echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
		// 	exit();
		// }
		if (isset($_POST['llogo'])) {
			$logolama = htmlspecialchars($_POST['logolama']);
			//cek apakah user pilih gambar baru atau tidak
			if ($_FILES['logo']['error'] === 4) {
				$logo = $logolama;
			} else {
				$logo = upload();
			}
		} else {
			$logo = "";
		}
		$query = $connect->prepare("select * from saplikasi where kd_perusahaan=? and id<>?");
		$query->bind_param('si', $_POST['kd_perusahaan'], $_POST['id']);
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
		$user_input = "Update-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$direktur = $_POST['direktur'];
		$finance_mgr = $_POST['finance_mgr'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$noso = $_POST['noso'];
		$nojual = $_POST['nojual'];
		$nopo = $_POST['nopo'];
		$nobeli = $_POST['nobeli'];
		$nokeluar = $_POST['nokeluar'];
		$noterima = $_POST['noterima'];
		$noopname = $_POST['noopname'];
		$noapprov = $_POST['noapprov'];
		$nokwtunai = $_POST['nokwtunai'];
		$nokwtagihan = $_POST['nokwtagihan'];
		$nomohon = $_POST['nomohon'];
		$nokwkeluar = $_POST['nokwkeluar'];
		$dirbackup = $_POST['dirbackup'];
		$kunci_harga_jual = $_POST['kunci_harga_jual'];
		$norek1 = $_POST['norek1'];
		$norek2 = $_POST['norek2'];
		$kunci_stock = $_POST['kunci_stock'];

		$query = $connect->prepare("update saplikasi set kd_perusahaan=?,nm_perusahaan=?,alamat=?,telp=?,npwp=?,jenis_hpp=?,aktif=?,direktur=?,finance_mgr=?,bulan=?,tahun=?,noso=?,nojual=?,nopo=?,nobeli=?,nokeluar=?,noterima=?,noopname=?,noapprov=?,nokwtunai=?,nokwtagihan=?,nomohon=?,nokwkeluar=?,user=?,logo=?,dirbackup=?,kunci_harga_jual=?,norek1=?,norek2=?,kunci_stock=? where id=?");
		$query->bind_param(
			'ssssssssssssssssssssssssssssssi',
			$_POST['kd_perusahaan'],
			$_POST['nm_perusahaan'],
			$_POST['alamat'],
			$_POST['telp'],
			$_POST['npwp'],
			$_POST['jenis_hpp'],
			$_POST['aktif'],
			$direktur,
			$finance_mgr,
			$bulan,
			$tahun,
			$noso,
			$nojual,
			$nopo,
			$nobeli,
			$nokeluar,
			$noterima,
			$noopname,
			$noapprov,
			$nokwtunai,
			$nokwtagihan,
			$nomohon,
			$nokwkeluar,
			$user_input,
			$logo,
			$dirbackup,
			$kunci_harga_jual,
			$norek1,
			$norek2,
			$kunci_stock,
			$_POST['id']
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
			session_start();
			$sql = "SELECT * FROM saplikasi WHERE aktif='Y'";
			$result = mysqli_query($connect, $sql);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['kd_perusahaan'] = $row['kd_perusahaan'];
			$_SESSION['nm_perusahaan'] = $row['nm_perusahaan'];
			$_SESSION['alamat_perusahaan'] = $row['alamat'];
			$_SESSION['telp_perusahaan'] = $row['telp'];
			$_SESSION['nm_sistem'] = $row['nm_sistem'];
			$_SESSION['direktur'] = $row['direktur'];
			$_SESSION['finance_mgr'] = $row['finance_mgr'];
			$_SESSION['logo'] = $row['logo'];
			$_SESSION['kunci_harga_jual'] = $row['kunci_harga_jual'];
			echo 'Logo ' . $_SESSION['logo'];
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=tbgolongan';
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
					window.history.go(-2); //window.location.href='../../dashboard.php?m=tbgolongan';
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

		//echo $namaFileBaru;
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