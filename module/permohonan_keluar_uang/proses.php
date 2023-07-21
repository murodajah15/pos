<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');

		$user = $_SESSION['username'];
		$user_proses = "Proses-".$user."-".date('d-m-Y H:i:s');
		$tglselesai = date('Y-m-d H:i:s');
		$proses = 'Y';

		$tampil = mysqli_query($connect,"select * from mohklruangh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nomohon = $de['nomohon'];
		if ($de['proses']=='Y' or $de['total']==0) {
			$text = "Dokumen ".$nomohon." Sudah di proses atau total masih 0 (nol) !";
			?>
			<script>
				swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}
		$ntotal=hit_total($connect,$nomohon);
		$materai = $de['materai'];
		$nsubtotal=hit_total($connect,$nomohon);
		$ntotal = $nsubtotal + $materai;
		$query = $connect->prepare("update mohklruangh set proses=?,subtotal=?,total=?,kurang=?,user_proses=? where id=?");
		$query->bind_param('siiisi',$proses,$nsubtotal,$ntotal,$ntotal,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			$queryd=mysqli_query($connect,"select * from mohklruangd where nomohon='$nomohon'");
			while ($rowd = mysqli_fetch_assoc($queryd)) {
				$id=$rowd['id'];
				$uang = $rowd['uang'];
				$nodokumen = $rowd['nodokumen'];
				mysqli_query($connect,"update mohklruangd set kurang=uang where id='$id'");
			}
			?>
			<script>
				swal({title: "Data berhasil diproses", text: "", icon: 
				"success"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=tbbank';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal proses data", text: "", icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
				   }
				);
			</script>
			<?php
		}		
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$nomohon)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(uang) as nsubtotal from mohklruangd where nomohon='$nomohon'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>	
</body>