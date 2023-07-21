<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nama'])){
			/*proses simpan**/
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			$query = $connect->prepare("select * from tbsatuan where kode=?");
			$query->bind_param('s',$_POST['kode']);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				// echo "<script>alert('Kode tersebut sudah digunakan');
				// 	window.location.href='../../dashboard.php?m=tbsatuan';
				// 	</script>";							
				?>
				<script>
					swal({title: "Gagal simpan data !", text: "Kode tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.history.go(-1);} //{window.location.href='../../dashboard.php?m=tbsatuan';
					   //}
					);
				</script>
				<?php
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$kode = strip_tags($_POST['kode']);
			$nama = strip_tags($_POST['nama']);
			$query = $connect->prepare("INSERT INTO tbsatuan (kode,nama,user) values (?,?,?)");
			$query->bind_param('sss',$kode,$nama,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=tbsatuan';
				// </script>";							
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=tbsatuan';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=tbsatuan';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data !", text: "", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=tbsatuan';
					   }
					);
				</script>
				<?php
			}		
		}else{
			header("location:../../dashboard.php?m=tbsatuan");
		}
	?>
</body>