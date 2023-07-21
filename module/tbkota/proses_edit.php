<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kode'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from tbkota where kode='$_POST[kode]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				/*echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";**/
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "Kode tersebut sudah digunakan!", icon: 
					"error"}).then(function(){window.history.back();
					   }
					);
				</script>
				<?php
				exit();
			}
			// $user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			// mysqli_query($connect,"update tbkota set kode='$_POST[kode]',nama='$_POST[nama]',aktif='$_POST[aktif]',user='$user' where id='$_POST[id]'");
			// header("location:../../dashboard.php?m=tbkota");
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$kode = strip_tags($_POST['kode']);
				$nama = strip_tags($_POST['nama']);
				$query = $connect->prepare("update tbkota set kode=?,nama=?,aktif=?,user=? where id=?");
				$query->bind_param('ssssi',$kode,$nama,$_POST['aktif'],$user_input,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=tbkota';
					// </script>";													
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.location.href='../../dashboard.php?m=tbkota';
						   }
						);
					</script>
					<?php
				}else{
					// echo "<script>alert('Gagal simpan data !');
					// window.location.href='../../dashboard.php?m=tbkota';
					// </script>";							
					?>
					<script>
						swal({title: "Gagal simpan data ", text: "", icon: 
						"error"}).then(function(){window.location.href='../../dashboard.php?m=tbkota';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=tbkota");
		}
	?>
</body>
