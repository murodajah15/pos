<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kode'])){
			//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$query = $connect->prepare("select * from tbjntrans where kode=? and id<>?");
			$query->bind_param('si',$_POST['kode'],$_POST['id']);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				// echo "<script>alert('Kode tersebut sudah digunakan');
				// 	window.location.href='../../dashboard.php?m=tbjntrans';
				// 	</script>";							
				?>
				<script>
					swal({title: "Gagal simpan data", text: "Kode tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=tbjntrans';
					   }
					);
				</script>
				<?php
				exit();
			}
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$kode = strip_tags($_POST['kode']);
			$nama = strip_tags($_POST['nama']);
			$keterangan = strip_tags($_POST['keterangan']);
			$query = $connect->prepare("update tbjntrans set kode=?,nama=?,keterangan=?,user=? where id=?");
			$query->bind_param('ssssi',$kode,$nama,$keterangan,$user_input,$_POST['id']);
			if($query->execute() and mysqli_affected_rows($connect)>0) {
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=tbjntrans';
				// </script>";										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbjntrans';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=tbjntrans';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbjntrans';
					   }
					);
				</script>
				<?php
			}			
		}else{
			header("location:../../dashboard.php?m=tbjntrans");
		}
	?>
</body>