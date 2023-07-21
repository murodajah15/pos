<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nokeluar'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from keluarh where nokeluar='$_POST[nokeluar]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				// $user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				// mysqli_query($connect,"update wo set kode='$_POST[kode]',nama='$_POST[nama]',aktif='$_POST[aktif]',user='$user' where id='$_POST[id]'");
				// header("location:../../dashboard.php?m=wo");
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nokeluar = strip_tags($_POST['nokeluar']);
				$tglkeluar = strip_tags($_POST['tglkeluar']);
				$noreferensi = strip_tags($_POST['noreferensi']);
				$tgldokumen = strip_tags($_POST['tgldokumen']);
				$kdjntrans = strip_tags($_POST['kdjntrans']);
				$kdgudang = strip_tags($_POST['kdgudang']);
				$biaya_lain = strip_tags($_POST['biaya_lain']);
				$total = strip_tags($_POST['total']);
				$keterangan = strip_tags($_POST['keterangan']);

				$query = $connect->prepare("update keluarh set nokeluar=?,tglkeluar=?,noreferensi=?,tgldokumen=?,kdjntrans=?,kdgudang=?,biaya_lain=?,total=?,keterangan=?,user=? where id=?");
				$query->bind_param('ssssssssssi',$nokeluar,$tglkeluar,$noreferensi,$tgldokumen,$kdjntrans,
				$kdgudang,$biaya_lain,$total,$keterangan,$user_input,$_POST['id']);				
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
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
						"error"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=keluar");
		}
	?>

	<?php
	//pembuatan fungsi
	function hit_total($connect,$nokeluar,$ppn)
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

</body>

