<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//membuat variabel untuk menyimpan data inputan yang di isikan di form
		$username 				= $_POST['id'];
		$password_lama			= $_POST['password_lama'];
		$password_baru			= $_POST['password_baru'];
		$konfirmasi_password	= $_POST['konfirmasi_password'];
		//cek dahulu ke database dengan query SELECT
		//kondisi adalah WHERE (dimana) kolom password adalah $password_lama di encrypt m5
		//encrypt -> md5($password_lama)
		$password_lama	= md5($password_lama);
		$cek 			= mysqli_query($connect,"SELECT * FROM user where password='$password_lama'");
		
		if($cek->num_rows){
			//kondisi ini jika password lama yang dimasukkan sama dengan yang ada di database
			//membuat kondisi minimal password adalah 5 karakter
			/**if(strlen($password_baru) >= 5){**/
				//jika password baru sudah 5 atau lebih, maka lanjut ke bawah
				//membuat kondisi jika password baru harus sama dengan konfirmasi password
				if($password_baru == $konfirmasi_password){
					//jika semua kondisi sudah benar, maka melakukan update kedatabase
					//query UPDATE SET password = encrypt md5 password_baru
					//kondisi WHERE id user = session id pada saat login, maka yang di ubah hanya user dengan id tersebut
					$password_baru 	= md5($password_baru);
					$update 		= mysqli_query($connect,"UPDATE user SET password='$password_baru' WHERE username='$username'");
					if($update){
						//kondisi jika proses query UPDATE berhasil
						// echo 'Password berhasil di rubah';
						// header("location:../../dashboard.php");
						?>
						<script>
							swal({title: "Password berhasil dirubah", text: "", icon: 
							"success"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbbank';
							   }
							);
						</script>
						<?php			
					}else{
						//kondisi jika proses query gagal
						echo 'Gagal merubah password';
					}					
				}else{
					//kondisi jika password baru beda dengan konfirmasi password
					//echo 'Konfirmasi password tidak cocok';
					//echo "<script>alert('Password lama tidak cocok, silahkan ulangi !');history.go(-1) </script>";
					?>
					<script>
						swal({title: "Password lama tidak cocok", text: "Silahkan diulangi", icon: 
						"error"}).then(function(){window.history.go(-1); //window.location.href='../../dashboard.php?m=tbbank';
						   }
						);
					</script>
					<?php			

				}
			/*}else{
				//kondisi jika password baru yang dimasukkan kurang dari 5 karakter
				echo 'Minimal password baru adalah 5 karakter';
			}**/
		}else{
			//kondisi jika password lama tidak cocok dengan data yang ada di database
			//echo 'Password lama tidak cocok';
			//echo "<script>alert('Password lama tidak cocok, silahkan ulangi !');history.go(-1) </script>";
			?>
			<script>
				swal({title: "Password lama tidak cocok", text: "Silahkan diulangi", icon: 
				"error"}).then(function(){window.history.go(-1); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php			
		}
	?>
</body>