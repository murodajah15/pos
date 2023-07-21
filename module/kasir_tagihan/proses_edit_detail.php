<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nojual'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from kasir_tagihand where nojual='$_POST[nojual]' and nokwitansi='$_POST[nokwitansi]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nokwitansi = strip_tags($_POST['nokwitansi']);
				$bayar = strip_tags($_POST['bayar']);
				$query = $connect->prepare("update kasir_tagihand set bayar=?,user=? where id=?");
				$query->bind_param('ssi',$bayar,$user_input,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
					$tampil = mysqli_query($connect,"select * from kasir_tagihan where nokwitansi='$nokwitansi'");
					$de = mysqli_fetch_assoc($tampil);

					$nokwitansi = $de['nokwitansi'];
					$materai = $de['materai'];
					$nsubtotal = hit_total($connect,$nokwitansi);
					$ntotal = $de['materai']+$nsubtotal;
					$query = $connect->prepare("update kasir_tagihan set subtotal=?,total=? where nokwitansi=?");
					$query->bind_param('sss',$nsubtotal,$nsubtotal,$ntotal,$nokwitansi);
					if($query->execute() and mysqli_affected_rows($connect)>0){
					}
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=so';
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
						"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=so';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=kasir_tagihan");
		}
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$nokwitansi)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(bayar) as nsubtotal from kasir_tagihand where nokwitansi='$nokwitansi'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>
	
</body>
