<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nama'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from tbprovinsi where kode='$_POST[kode]'"));
			if ($cek > 0){
				echo "<script>alert('Kode sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}

			// $user = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			// $query = mysqli_query($connect,"insert into tbprovinsi (kode,nama,aktif,user) values 
			// ('$_POST[kode]','$_POST[nama]','$_POST[aktif]','$user')");	
			// if($query){
			// 	header("location:../../dashboard.php?m=tbprovinsi");
			// }else{
			// 	echo "<script>alert('Gagal Simpan Data !');history.go(-1);</script>";
			// }
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$kode = strip_tags($_POST['kode']);
			$nama = strip_tags($_POST['nama']);
			$query = $connect->prepare("INSERT INTO tbprovinsi (kode,nama,aktif,user) values (?,?,?,?)");
			$query->bind_param('ssss',$kode,$nama,$_POST['aktif'],$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=tbprovinsi';
				// </script>";							
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=tbprovinsi';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=tbprovinsi';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=tbprovinsi';
					   }
					);
				</script>
				<?php
			}		
		}else{
			header("location:../../dashboard.php?m=tbprovinsi");
		}
	?>
</body>