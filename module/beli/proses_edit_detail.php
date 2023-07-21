<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kdbarang'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			if (!empty($_POST['nopo'])) {
				$de = mysqli_fetch_assoc(mysqli_query($connect,"select * from pod where kdbarang='$_POST[kdbarang]' and nopo='$_POST[nopo]'"));
				$kurang = $de['kurang'];
				if ($kurang < $_POST['qty']) {
					echo "<script>alert('QTY terima tidak boleh lebih dari sisa pesanan');history.go(-1) </script>";
					exit();
				}
			}
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$qty = $_POST['qty'];
			$harga = $_POST['harga'];
			$discount = $_POST['discount'];
			$subtotal = $_POST['subtotal'];
			$subtotal = ($qty*$harga) - (($qty*$harga)*$discount/100);
			$query = $connect->prepare("update belid set qty=?,harga=?,discount=?,subtotal=?,user=? where id=?");
			$query->bind_param('ssssss',$qty,$harga,$discount,$subtotal,$user_input,$_POST['id']);
			if($query->execute()){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";													
				$query = mysqli_query($connect,"select sum(subtotal) as nsubtotal from belid where nobeli='$_POST[nobeli]'");
				$k = mysqli_fetch_assoc($query);
				$subtotal = $k['nsubtotal'];
				mysqli_query($connect,"update belih set subtotal='$subtotal', total='$subtotal'+total_sementara+materai+(total_sementara*(ppn/100)) where nobeli='$_POST[nobeli]'");

				$query = $connect->prepare("update belid set qty=?,harga=?,discount=?,subtotal=?,user=? where id=?");
				$query->bind_param('ssssss',$qty,$harga,$discount,$subtotal,$user_input,$_POST['id']);
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=order_part';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-1); //then(function(){window.location.href='../../dashboard.php?m=order_part';
					   }
					);
				</script>
				<?php
			}		

		}else{
			header("location:../../dashboard.php?m=beli");
		}
	?>
</body>
