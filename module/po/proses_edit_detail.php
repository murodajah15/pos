<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kdbarang'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from pod where kdbarang='$_POST[kdbarang]' and nopo='$_POST[nopo]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nopo = strip_tags($_POST['nopo']);
				$kdbarang = strip_tags($_POST['kdbarang']);
				$nmbarang = strip_tags($_POST['nmbarang']);
				$kdsatuan = strip_tags($_POST['kdsatuan']);
				$qty = $_POST['qty'];
				$harga = $_POST['harga'];
				$discount = $_POST['discount'];
				$subtotal = $_POST['subtotal'];
				$subtotal = ($qty*$harga) - (($qty*$harga)*$discount/100);
				$query = $connect->prepare("update pod set kdbarang=?,nmbarang=?,kdsatuan=?,qty=?,harga=?,discount=?,subtotal=?,user=? where id=?");
				$query->bind_param('ssssssssi',$kdbarang,$nmbarang,$kdsatuan,$qty,$harga,$discount,$subtotal,$user_input,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
					$tampil = mysqli_query($connect,"select * from poh where nopo='$nopo'");
					$de = mysqli_fetch_assoc($tampil);
					$ppn = $de['ppn'];
					$nopo = $de['nopo'];
					$materai = $de['materai'];
					$ntotal=hit_total($connect,$nopo,$ppn);
					$total_sementara = $de['biaya_lain']+$nsubtotal;
					$ntotal = $total_sementara + ($total_sementara*($ppn/100)) + $materai;
					$query = $connect->prepare("update poh set subtotal=?,total=?,total_sementara=? where nopo=?");
					$query->bind_param('ssss',$nsubtotal,$ntotal,$total_sementara,$nopo);
					if($query->execute() and mysqli_affected_rows($connect)>0){
					}
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=po';
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
						"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=po';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=po");
		}
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$nopo,$ppn)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from pod where nopo='$nopo'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>
	
</body>
