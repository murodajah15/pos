<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nopo'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from poh where nopo='$_POST[nopo]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				// $user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				// mysqli_query($connect,"update wo set kode='$_POST[kode]',nama='$_POST[nama]',aktif='$_POST[aktif]',user='$user' where id='$_POST[id]'");
				// header("location:../../dashboard.php?m=wo");
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nopo = strip_tags($_POST['nopo']);
				$tglpo = strip_tags($_POST['tglpo']);
				$noreferensi = strip_tags($_POST['noreferensi']);
				$kdsupplier = strip_tags($_POST['kdsupplier']);
				$nmsupplier = strip_tags($_POST['nmsupplier']);
				$jenis_order = strip_tags($_POST['jenis_order']);
				$tglkirim = strip_tags($_POST['tglkirim']);
				$biaya_lain = strip_tags($_POST['biaya_lain']);
				$ket_biaya_lain = strip_tags($_POST['ket_biaya_lain']);
				$carabayar = strip_tags($_POST['carabayar']);
				$tempo = strip_tags($_POST['tempo']);
				$tgl_jt_tempo = strip_tags($_POST['tgl_jt_tempo']);
				$ppn = strip_tags($_POST['ppn']);
				$materai = strip_tags($_POST['materai']);
				$keterangan = strip_tags($_POST['keterangan']);
				$ntotal=hit_total($connect,$nopo,$ppn);
				$total_sementara = $_POST['biaya_lain']+$nsubtotal;
				$ntotal = $total_sementara + ($total_sementara*($ppn/100)) + $materai;
				$query = $connect->prepare("update poh set nopo=?,tglpo=?,noreferensi=?,kdsupplier=?,nmsupplier=?,jenis_order=?,tglkirim=?,biaya_lain=?,ket_biaya_lain=?,carabayar=?,ppn=?,materai=?,keterangan=?,user=?,subtotal=?,total=?,tempo=?,tgl_jt_tempo=?,total_sementara=? where id=?");
				$query->bind_param('ssssssssssssssssssss',$nopo,$tglpo,$noreferensi,$kdsupplier,$nmsupplier,$jenis_order,$tglkirim,$biaya_lain,$ket_biaya_lain,$carabayar,$ppn,$materai,$keterangan,$user_input,$nsubtotal,$ntotal,$tempo,$tgl_jt_tempo,$total_sementara,$_POST['id']);				
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.location.href='../../dashboard.php?m=po';
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
						"error"}).then(function(){window.location.href='../../dashboard.php?m=po';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=po");
		}
	?>

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

</body>

