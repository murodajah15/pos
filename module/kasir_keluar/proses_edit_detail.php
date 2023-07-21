<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		$nokwitansi = $_POST['nokwitansi'];
		if(!empty($_POST['nodokumen'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			$query = mysqli_query($connect,"select * from mohklruangd where nodokumen='$_POST[nodokumen]'");
			$rec = mysqli_num_rows($query);
			if ($rec>0) {
				$de = mysqli_fetch_assoc($query);
				$kurang = $de['kurang'];
				if ($kurang < $_POST['uang']) {
					echo "<script>alert('Pembayaran melebihi permohonan, tidak bisa simpan !');history.go(-1) </script>";
					exit();
				}
			}
		}
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$nmsupplier = $_POST['nmsupplier'];
			$keterangan = $_POST['keterangan'];
			$uang = $_POST['uang'];

			$query = $connect->prepare("update kasir_keluard set nmsupplier=?,keterangan=?,uang=?,user=? where id=?");
			$query->bind_param('ssssi',$nmsupplier,$keterangan,$uang,$user_input,$_POST['id']);
			if($query->execute()){
				$query = mysqli_query($connect,"select sum(uang) as nsubtotal from kasir_keluard where nokwitansi='$_POST[nokwitansi]'");
				$k = mysqli_fetch_assoc($query);
				$total = $k['nsubtotal'];
				mysqli_query($connect,"update kasir_keluarh set subtotal='$total', total=$total+materai where nokwitansi='$_POST[nokwitansi]'");
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=order_part';
					   }
					);
				</script>
				<?php
			}else{
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-1); //then(function(){window.location.href='../../dashboard.php?m=order_part';
					   }
					);
				</script>
				<?php
			}		
			header("location:../../dashboard.php?m=kasir_keluar&tipe=detail&nokwitansi=$nokwitansi");
		?>
</body>
