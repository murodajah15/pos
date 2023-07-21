<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nokwitansi'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$nojual = strip_tags($_POST['nojual']);
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from kasir_tagihand where nojual='$nojual' and nokwitansi='$_POST[nokwitansi]'"));
			if ($cek > 0){
				echo "<script>alert('Double No. Jual, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$nokwitansi = strip_tags($_POST['nokwitansi']);
			$nojual = strip_tags($_POST['nojual']);
			$kdcustomer = strip_tags($_POST['kdcustomer']);
			$nmcustomer = strip_tags($_POST['nmcustomer']);
			$piutang = $_POST['piutang'];
			$bayar = $_POST['bayar'];

			$query = $connect->prepare("INSERT INTO kasir_tagihand (nokwitansi,nojual,kdcustomer,nmcustomer,piutang,bayar,user) values (?,?,?,?,?,?,?)");
			$query->bind_param('sssssss',$nokwitansi,$nojual,$kdcustomer,$nmcustomer,$piutang,$bayar,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				$tampil = mysqli_query($connect,"select * from kasir_tagihan where nokwitansi='$nokwitansi'");
				$de = mysqli_fetch_assoc($tampil);
				$nokwitansi = $de['nokwitansi'];
				$materai = $de['materai'];
				$ntotal=hit_total($connect,$nokwitansi);
				$total_sementara = $nsubtotal;
				$ntotal = $total_sementara + $materai;
				echo $nsubtotal.'   '.$ntotal;
				$query = $connect->prepare("update kasir_tagihan set subtotal=?,total=? where nokwitansi=?");
				$query->bind_param('iis',$nsubtotal,$ntotal,$nokwitansi);
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