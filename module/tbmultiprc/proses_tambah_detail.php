<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['kdcustomer'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$kdbarang = strip_tags($_POST['kdbarang']);
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from tbmultiprc where kdbarang='$kdbarang' and kdcustomer='$_POST[kdcustomer]'"));
			if ($cek > 0){
				echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from tbbarang where kode='$kdbarang'"));
			if ($cek == 0){
				echo "<script>alert('Kode Barang tidak ada di tabel barang, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}			
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$kdcustomer = strip_tags($_POST['kdcustomer']);
			$kdbarang = strip_tags($_POST['kdbarang']);
			$nmbarang = strip_tags($_POST['nmbarang']);
			$harga = $_POST['harga'];
			$discount = $_POST['discount'];
			$query = $connect->prepare("INSERT INTO tbmultiprc (kdcustomer,kdbarang,nmbarang,harga,discount,user) values (?,?,?,?,?,?)");
			$query->bind_param('ssssss',$kdcustomer,$kdbarang,$nmbarang,$harga,$discount,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
				<?php
			}else{
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
				<?php
			}		
		}else{
			header("location:../../dashboard.php?m=tbmultiprc");
		}
	?>
</body>