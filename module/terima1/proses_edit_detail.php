<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kdbarang'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from terimad where kdbarang='$_POST[kdbarang]' and noterima='$_POST[noterima]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$noterima = strip_tags($_POST['noterima']);
				$kdbarang = strip_tags($_POST['kdbarang']);
				$nmbarang = strip_tags($_POST['nmbarang']);
				$kdsatuan = strip_tags($_POST['kdsatuan']);
				$qty = $_POST['qty'];
				$harga = $_POST['harga'];
				$subtotal = $_POST['subtotal'];
				//mysqli_query($connect,"update terimad set qty='$qty' where id='$_POST[id]'");
				$query = $connect->prepare("update terimad set kdbarang=?,nmbarang=?,kdsatuan=?,qty=?,harga=?,subtotal=?,user=? where id=?");
				$query->bind_param('sssssssi',$kdbarang,$nmbarang,$kdsatuan,$qty,$harga,$subtotal,$user_input,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
					$tampil = mysqli_query($connect,"select * from terimah where noterima='$noterima'");
					$de = mysqli_fetch_assoc($tampil);
					$noterima = $de['noterima'];
					$biaya_lain = $de['biaya_lain'];
					$nsubtotal=hit_total($connect,$noterima);
					$ntotal = $biaya_lain + $nsubtotal;
					$query = $connect->prepare("update terimah set subtotal=?,total=? where noterima=?");
					$query->bind_param('iis',$nsubtotal,$ntotal,$noterima);
					if($query->execute() and mysqli_affected_rows($connect)>0){
					}
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=terima';
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
						"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=terima';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=terima");
		}
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$noterima)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from terimad where noterima='$noterima'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>
	
</body>
