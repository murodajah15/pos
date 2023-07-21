<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nama'])){
			/*proses simpan**/
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			$query = $connect->prepare("select * from tbsales where kode=?");
			$query->bind_param('s',$_POST['kode']);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				// echo "<script>alert('Kode tersebut sudah digunakan');
				// 	window.location.href='../../dashboard.php?m=tbsales';
				// 	</script>";							
				?>
				<script>
					swal({title: "Gagal simpan data !", text: "Kode tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.history.go(-1);} //{window.location.href='../../dashboard.php?m=tbsales';
					   //}
					);
				</script>
				<?php
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$kode = strip_tags($_POST['kode']);
			$nama = strip_tags($_POST['nama']);
			$initial = htmlspecialchars($_POST['initial']);
			$telp1 = htmlspecialchars($_POST['telp1']);
			$telp2 = htmlspecialchars($_POST['telp2']);
			$alamat = htmlspecialchars($_POST['alamat']);
			$kota = htmlspecialchars($_POST['kota']);
			$kdpos = htmlspecialchars($_POST['kdpos']);
			$keterangan = htmlspecialchars($_POST['keterangan']);
			$query = $connect->prepare("INSERT INTO tbsales (kode,nama,initial,telp1,telp2,alamat,kota,kdpos,keterangan,user) values (?,?,?,?,?,?,?,?,?,?)");
			$query->bind_param('ssssssssss',$kode,$nama,$initial,$telp1,$telp2,$alamat,$kota,$kdpos,$keterangan,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=tbsales';
				// </script>";							
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=tbsales';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=tbsales';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data !", text: "", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=tbsales';
					   }
					);
				</script>
				<?php
			}		
		}else{
			header("location:../../dashboard.php?m=tbsales");
		}
	?>
</body>