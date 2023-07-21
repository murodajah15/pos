<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['username'])){
			//proses simpan
			// $username = $_POST['username'];
			// $sql=mysqli_query($connect,"select * from user where username='$username'");
			// $row=mysqli_num_rows($sql);
			// if ($row>0) {;
				// echo "<script>
				// window.location.href='../../dashboard.php?m=user&tipe=tambah';
				// alert('User sudah ada, data tidak bisa disimpan !');
				// </script>";
			$query = $connect->prepare("select * from user where username=?");
			$query->bind_param('s',$_POST['username']);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				?>
				<script>
					swal({title: "Gagal simpan data", text: "User tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=user&tipe=tambah';
					   }
					);
				</script>
				<?php
				exit();
			}else{
				//upload gambar
				$photo = upload();
				// if( !$photo ) {
				// 	return false;
				// }			
				$password = $_POST['password'];
				$pass=md5($password);
				// $query = mysqli_query($connect,"insert into user (username,password,nama_lengkap,email,telp,aktif,level,kdese_kdsat,kdeselon,photo) values 
				// 	('$_POST[username]','$pass','$_POST[nama_lengkap]','$_POST[email]','$_POST[telp]','$_POST[aktif]','$_POST[level]','$_POST[kdese_kdsat]','$_POST[kdeselon]','$photo')");
				// if($query){
					// echo "<script>alert('Data berhasil disimpan !');window.location.href='../../dashboard.php?m=user'; </script>";		
					/*header("location:../../dashboard.php?m=user");**/
				$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
				$username = strip_tags($_POST['username']);
				$nama_lengkap = strip_tags($_POST['nama_lengkap']);
				$email = strip_tags($_POST['email']);
				$telp = strip_tags($_POST['telp']);
				$aktif = strip_tags($_POST['aktif']);
				$level = strip_tags($_POST['level']);
				// $query = $connect->prepare("INSERT INTO user (username,password,nama_lengkap,email,telp,aktif,level,kdese_kdsat,kdeselon,photo) values (?,?,?,?,?,?,?,?,?)");
				// $query->bind_param('sssssssss',$username,$pass,$nama_lengkap,$email,$telp,$aktif,$level,$kdese_kdsat,$kdeselon,$photo);
				$query = $connect->prepare("INSERT INTO user (username,password,nama_lengkap,email,telp,aktif,level,photo,user_input) values (?,?,?,?,?,?,?,?,?)");
				$query->bind_param('sssssssss',$username,$pass,$nama_lengkap,$email,$telp,$aktif,$level,$photo,$user_input);
				if($query->execute() and (mysqli_affected_rows($connect)>0)){
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=user';
						   }
						);
					</script>
					<?php					
				}else{
					// echo "<script>alert('Gagal simpan data !');window.location.href='../../dashboard.php?m=user'; </script>";
					/*echo "<script>alert('Gagal Simpan Data !');history.go(-1);</script>";**/
					?>
					<script>
						swal({title: "Gagal simpan data ", text: "", icon: 
						"error"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=user';
						   }
						);
					</script>
					<?php					

				}
			}
		}else{
			header("location:../../dashboard.php?m=user");
		}
	?>

	<?php
		function upload() {
			$namaFile = $_FILES['photo']['name'];
			$ukuranFile = $_FILES['photo']['size'];
			$error = $_FILES['photo']['error'];
			$tmpName = $_FILES['photo']['tmp_name'];

				// cek apakah tidak ada photo yang diupload
				if($error === 4) {
					echo "<script>
						alert('pilih photo!');
					  </script>";
					return false;
			}

			// cek apakah yang diupload adalah photo
			$ekstensiphotoValid = ['jpg', 'jpeg', 'png', 'bmp', 'tiff'];
			$ekstensiphoto = explode('.', $namaFile); 
			$ekstensiphoto = strtolower(end($ekstensiphoto));
			if( !in_array($ekstensiphoto, $ekstensiphotoValid)) {
				echo "<script>
					alert('Pilihlah File photo!');
				  </script>";
				return false;
			}

			// cek jika ukurannya terlalu besar
			if($ukuranFile > 4000000) {
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

			echo $namaFileBaru;
			$dir = '../../photo/';
			if (is_dir($dir)){
				move_uploaded_file($tmpName, '../../photo/'.$namaFileBaru);
			}else{
				move_uploaded_file($tmpName, '/../photo/'.$namaFileBaru);
			}
			return $namaFileBaru;
		}
	?>
</body>
