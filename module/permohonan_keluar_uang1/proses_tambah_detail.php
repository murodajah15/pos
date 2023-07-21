<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nomohon'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$nodokumen = strip_tags($_POST['nodokumen']);
			if (!empty($nodokumen)) {
				$cek = mysqli_num_rows(mysqli_query($connect,"select * from mohklruangd where nodokumen='$nodokumen' and nomohon='$_POST[nomohon]'"));
				if ($cek > 0){
					echo "<script>alert('Double barang, data tidak bisa disimpan !');history.go(-1) </script>";
					exit();
				}
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$nomohon = strip_tags($_POST['nomohon']);
			$nodokumen = strip_tags($_POST['nodokumen']);
			if (empty($nodokumen)) {
				//$nodokumen = $nomohon.uniqid();
				$tgldokumen = $_POST['tglmohon'];
			}else{
				$tgldokumen = strip_tags($_POST['tgldokumen']);	
			}
			$kdsupplier = strip_tags($_POST['kdsupplier']);
			$nmsupplier = strip_tags($_POST['nmsupplier']);
			$keterangan = strip_tags($_POST['keterangan']);
			$uang = strip_tags($_POST['uang']);

			$query = $connect->prepare("INSERT INTO mohklruangd (nomohon,nodokumen,tgldokumen,kdsupplier,nmsupplier,keterangan,uang,user) values (?,?,?,?,?,?,?,?)");
			$query->bind_param('ssssssis',$nomohon,$nodokumen,$tgldokumen,$kdsupplier,$nmsupplier,$keterangan,$uang,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				$tampil = mysqli_query($connect,"select * from mohklruangh where nomohon='$nomohon'");
				$de = mysqli_fetch_assoc($tampil);
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
			header("location:../../dashboard.php?m=permohonan_keluar_uang");
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