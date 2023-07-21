<body>
	<script src="./js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "./inc/config.php";
		if(!empty($_POST['username'])){
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
				if ($_POST['password'] <> $_POST['konfirmasipassword']) {
					?>
					<script>
						swal({title: "Gagal simpan data", text: "Password konfirmasi tidak sama dengan Password!", icon: 
						"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=user&tipe=tambah';
						   }
						);
					</script>
					<?php
					exit();
				}
				$password = $_POST['password'];
				$pass=md5($password);
				$username = strip_tags($_POST['username']);
				$aktif = "N";
				$level = "ADMINISTRATOR";
				$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
				$query = $connect->prepare("INSERT INTO user (username,password,aktif,level,user_input) values (?,?,?,?,?)");
				$query->bind_param('sssss',$username,$pass,$aktif,$level,$user_input);
				if($query->execute() and (mysqli_affected_rows($connect)>0)){
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.location.href='index.php';
						   }
						);
					</script>
					<?php					
				}else{
					?>
					<script>
						swal({title: "Gagal simpan data ", text: "", icon: 
						"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=user';
						   }
						);
					</script>
					<?php					

				}
			}
		}else{
			header("location:index.php");
		}
	?>
</body>
