<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kdbarang'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from keluard where kdbarang='$_POST[kdbarang]' and nokeluar='$_POST[nokeluar]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nokeluar = strip_tags($_POST['nokeluar']);
				$kdbarang = strip_tags($_POST['kdbarang']);
				$nmbarang = strip_tags($_POST['nmbarang']);
				$kdsatuan = strip_tags($_POST['kdsatuan']);
				$qty = $_POST['qty'];
				$harga = $_POST['harga'];
				$subtotal = $_POST['subtotal'];
				$query = $connect->prepare("update keluard set kdbarang=?,nmbarang=?,kdsatuan=?,qty=?,harga=?,subtotal=?,user=? where id=?");
				$query->bind_param('sssssssi',$kdbarang,$nmbarang,$kdsatuan,$qty,$harga,$subtotal,$user_input,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
					$tampil = mysqli_query($connect,"select * from keluarh where nokeluar='$nokeluar'");
					$de = mysqli_fetch_assoc($tampil);
					$nokeluar = $de['nokeluar'];
					$biaya_lain = $de['biaya_lain'];
					$nsubtotal=hit_total($connect,$nokeluar);
					$ntotal = $biaya_lain + $nsubtotal;
					$query = $connect->prepare("update keluarh set subtotal=?,total=? where nokeluar=?");
					$query->bind_param('sss',$nsubtotal,$ntotal,$nokeluar);
					if($query->execute() and mysqli_affected_rows($connect)>0){
					}
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=keluar';
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
						"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=keluar';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=keluar");
		}
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$nokeluar)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from keluard where nokeluar='$nokeluar'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>
	
</body>
