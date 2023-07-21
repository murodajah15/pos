<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['tgldokumen'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			if(!empty($_POST['nodokumen'])) {
				//Cek Double
				$cek = mysqli_num_rows(mysqli_query($connect,"select * from mohklruangd where nodokumen='$_POST[nodokumen]' and nomohon='$_POST[nomohon]' and id<>'$_POST[id]'"));
				if ($cek > 0){
					echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
					exit();
				}
			}
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$nodokumen = strip_tags($_POST['nodokumen']);
			$nmsupplier = strip_tags($_POST['nmsupplier']);
			$keterangan = $_POST['keterangan'];
			$total = $_POST['total'];
			$query = $connect->prepare("update mohklruangd set nmsupplier=?,keterangan=?,uang=?,user=? where id=?");
			$query->bind_param('ssisi',$nmsupplier,$keterangan,$total,$user_input,$_POST['id']);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";													
				$tampil = mysqli_query($connect,"select * from mohklruangh where nomohon='$_POST[nomohon]'");
				$de = mysqli_fetch_assoc($tampil);
				$nomohon = $de['nomohon'];
				$materai = $de['materai'];
				$nsubtotal=hit_total($connect,$nomohon);
				$ntotal = $nsubtotal + $materai;
				$query = $connect->prepare("update mohklruangh set subtotal=?,total=? where nomohon=?");
				$query->bind_param('iis',$nsubtotal,$ntotal,$nomohon);
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
