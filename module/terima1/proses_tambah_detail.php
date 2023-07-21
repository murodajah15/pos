<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['noterima'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$kdbarang = strip_tags($_POST['kdbarang']);
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from terimad where kdbarang='$kdbarang' and noterima='$_POST[noterima]'"));
			if ($cek > 0){
				echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$noterima = strip_tags($_POST['noterima']);
			$kdbarang = strip_tags($_POST['kdbarang']);
			$nmbarang = strip_tags($_POST['nmbarang']);
			$qty = $_POST['qty'];
			$harga = $_POST['harga'];
			$subtotal = ($qty*$harga);

			$query=mysqli_query($connect,"select kode,kdsatuan from tbbarang where kode='$kdbarang'");
			$de=mysqli_fetch_assoc($query);
			$kdsatuan = strip_tags($de['kdsatuan']);
			
			$query = $connect->prepare("INSERT INTO terimad (noterima,kdbarang,nmbarang,kdsatuan,qty,harga,subtotal,user) values (?,?,?,?,?,?,?,?)");
			$query->bind_param('ssssssss',$noterima,$kdbarang,$nmbarang,$kdsatuan,$qty,$harga,$subtotal,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				$tampil = mysqli_query($connect,"select * from terimah where noterima='$noterima'");
				$de = mysqli_fetch_assoc($tampil);
				$noterima = $de['noterima'];
				$nsubtotal=hit_total($connect,$noterima);
				$ntotal = $de['biaya_lain']+$nsubtotal;
				$query = $connect->prepare("update terimah set subtotal=?,total=? where noterima=?");
				$query->bind_param('iis',$nsubtotal,$ntotal,$noterima);
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}
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