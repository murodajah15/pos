<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	//echo $_POST['password'];
	//proses simpan
	$password = $_POST['password'];
	$pass = md5($password);
	// echo $pass;
	$photolama = htmlspecialchars($_POST['photolama']);
	//cek apakah user pilih gambar baru atau tidak
	if ($_FILES['file']['error'] === 4) {
		$photo = $photolama;
	} else {
		$photo = upload();
	}
	$user_input = "Update-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
	if ($_POST['password'] == "") {
		// $query = mysqli_query($connect,"update user set username='$_POST[username]',nama_lengkap='$_POST[nama_lengkap]',
		// email='$_POST[email]',telp='$_POST[telp]',level='$_POST[level]',aktif='$_POST[aktif]',kdese_kdsat='$_POST[kdese_kdsat]',
		// kdeselon='$_POST[kdeselon]',photo='$photo' where id='$_POST[id]'");
		// if ($query >0) {
		// echo "<script>alert('Data berhasil disimpan !');window.location.href='../../dashboard.php?m=user';</script>";				
		// header("location:../../dashboard.php?m=user");
		$username = strip_tags($_POST['username']);
		$nama_lengkap = strip_tags($_POST['nama_lengkap']);
		$email = strip_tags($_POST['email']);
		$telp = strip_tags($_POST['telp']);
		$aktif = strip_tags($_POST['aktif']);
		$login = strip_tags($_POST['login']);
		$level = strip_tags($_POST['level']);
		$query = $connect->prepare("update user set username=?,nama_lengkap=?,email=?,telp=?,aktif=?,login=?,level=?,photo=?,user_input=? where id=?");
		$query->bind_param('sssssssssi', $username, $nama_lengkap, $email, $telp, $aktif, $login, $level, $photo, $user_input, $_POST['id']);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
	?>
			<script>
				swal({
					title: "Data berhasil disimpan",
					text: "",
					icon: "success"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=user';
				});
			</script>
			<?php
			/* Salin detail dari User lain **/
			if (isset($_POST['usersalin'])) {
				mysqli_query($connect, "delete from userdtl where username='$username'");
				$sql = mysqli_query($connect, "select * from tbmodule order by nurut");
				while ($de = mysqli_fetch_assoc($sql)) {
					mysqli_query($connect, "insert into userdtl (idmodule,username,cmodule,cmainmenu,nlevel,nurut,pakai,tambah,edit,hapus,proses,unproses,cetak) values ('$de[id]','$_POST[username]','$de[cmodule]','$de[cmainmenu]','$de[nlevel]','$de[nurut]','0','0','0','0','0','0','0')");
				}
				$sql = mysqli_query($connect, "select * from userdtl where username='$_POST[usersalin]' order by nurut");
				while ($de = mysqli_fetch_assoc($sql)) {
					mysqli_query($connect, "update userdtl set iduser='$_POST[id]',pakai='$de[pakai]',tambah='$de[tambah]',edit='$de[edit]',hapus='$de[hapus]',proses='$de[proses]',unproses='$de[unproses]',cetak='$de[cetak]' where username='$username' and cmodule='$de[cmodule]'");
				}
			}
		} else {
			?>
			<script>
				swal({
					title: "Gagal simpan data!",
					text: "",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=user';
				});
			</script>
		<?php
		}
	} else {
		// Cek Double
		$cek = mysqli_num_rows(mysqli_query($connect, "select * from user where username='$_POST[username]' and id<>'$_POST[id]'"));
		if ($cek > 0) {
			// echo "<script>alert('User Name sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
		?>
			<script>
				swal({
					title: "User Name sudah ada ",
					text: "data tidak bisa disimpan!",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=user';
				});
			</script>
		<?php
			exit();
		}

		// mysqli_query($connect,"update user set username='$_POST[username]',password='$pass',nama_lengkap='$_POST[nama_lengkap]',
		// email='$_POST[email]',telp='$_POST[telp]',level='$_POST[level]',aktif='$_POST[aktif]',kdese_kdsat='$_POST[kdese_kdsat]',
		// kdeselon='$_POST[kdeselon]',photo='$photo' where id='$_POST[id]'");
		// echo "<script>alert('Data berhasil disimpan !');window.location.href='../../dashboard.php?m=user';</script>";				
		// header("location:../../dashboard.php?m=user");
		$username = strip_tags($_POST['username']);
		$nama_lengkap = strip_tags($_POST['nama_lengkap']);
		$email = strip_tags($_POST['email']);
		$telp = strip_tags($_POST['telp']);
		$aktif = strip_tags($_POST['aktif']);
		$login = strip_tags($_POST['login']);
		$level = strip_tags($_POST['level']);
		$query = $connect->prepare("update user set username=?,password=?,nama_lengkap=?,email=?,telp=?,aktif=?,login=?,level=?,photo=?,user_input=? where id=?");
		$query->bind_param('sssssssssss', $username, $pass, $nama_lengkap, $email, $telp, $aktif, $login, $level, $photo, $user_input, $_POST['id']);
		//$query = $connect->prepare("update user set username=?,user_input=? where id=?");
		//$query->bind_param('sss',$username,$user_input,$_POST['id']);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			$dir = '../../photo/';
			if (is_dir($dir)) {
				unlink('../../photo/' . $photolama);
			} else {
				unlink('/../photo/' . $photolama);
			}
		?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=user';
				});
			</script>
		<?php
		} else {
		?>
			<script>
				swal({
					title: "Gagal simpan1 data!",
					text: "",
					icon: "error"
				}).then(function() {
					window.history.go(-2); //window.location.href='../../dashboard.php?m=user';
				});
			</script>
	<?php
		}
	}
	?>

	<?php
	function upload()
	{
		$namaFile = $_FILES['file']['name'];
		$ukuranFile = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmpName = $_FILES['file']['tmp_name'];

		// cek apakah tidak ada photo yang diupload
		if ($error === 4) {
			echo "<script>
					alert('pilih photo!');
				  </script>";
			return false;
		}

		// cek apakah yang diupload adalah photo
		$ekstensiphotoValid = ['jpg', 'jpeg', 'png', 'bmp', 'tiff'];
		$ekstensiphoto = explode('.', $namaFile);
		$ekstensiphoto = strtolower(end($ekstensiphoto));
		if (!in_array($ekstensiphoto, $ekstensiphotoValid)) {
			echo "<script>
					alert('Pilihlah File photo!');
				  </script>";
			return false;
		}

		// cek jika ukurannya terlalu besar
		if ($ukuranFile > 4000000) {
			echo "<script>
					alert('Ukuran photo Terlalu Besar!');
				  </script>";
			return false;
		}

		// lolos pengecekan, photo siap diupload
		// generate nama photo baru
		$namaFileBaru = uniqid();
		$namaFileBaru .= '.';
		$namaFileBaru .= $ekstensiphoto;

		//echo $namaFileBaru;
		$dir = '../../photo/';
		if (is_dir($dir)) {
			move_uploaded_file($tmpName, '../../photo/' . $namaFileBaru);
		} else {
			move_uploaded_file($tmpName, '/../photo/' . $namaFileBaru);
		}
		return $namaFileBaru;
	}
	?>
</body>