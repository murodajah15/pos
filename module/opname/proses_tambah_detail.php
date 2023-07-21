<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['noopname'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$kdbarang = strip_tags($_POST['kdbarang']);
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from opnamed where kdbarang='$kdbarang' and noopname='$_POST[noopname]'"));
			if ($cek > 0){
				echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$noopname = strip_tags($_POST['noopname']);
			$kdbarang = strip_tags($_POST['kdbarang']);
			$nmbarang = strip_tags($_POST['nmbarang']);
			$lokasi = strip_tags($_POST['lokasi']);
			$qty = $_POST['qty'];
			$query = $connect->prepare("INSERT INTO opnamed (noopname,kdbarang,nmbarang,lokasi,qty,user) values (?,?,?,?,?,?)");
			$query->bind_param('ssssis',$noopname,$kdbarang,$nmbarang,$lokasi,$qty,$user_input);
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
			header("location:../../dashboard.php?m=opname");
		}
	?>
</body>