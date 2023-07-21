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

		$tampil = mysqli_query($connect,"select * from soh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$ppn = $de['ppn'];
		$noso = $de['noso'];
		$tglso = $de['tglso'];

		if ($de['proses']=='Y' or $de['total']==0) {
			$text = "Dokumen ".$noso." Sudah di proses / total masih 0 (nol)!";
			?>
			<script>
				swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}
		$rec = mysqli_num_rows(mysqli_query($connect,"select * from sod where noso='$noso'"));
		if ($rec==0) {
			echo "<script>alert('Tidak ada detail barang, tidak bisa proses !');history.go(-1) </script>";
			exit();			
		}		
		$ntotal=hit_total($connect,$noso,$ppn);
		$materai = $de['materai'];
		$ntotal=hit_total($connect,$noso,$ppn);
		$total_sementara = $de['biaya_lain']+$nsubtotal;
		$ntotal = $total_sementara + ($total_sementara*($ppn/100)) + $materai;
		$query = $connect->prepare("update soh set proses=?,subtotal=?,total=?,user_proses=?,total_sementara=? where id=?");
		$query->bind_param('ssssss',$proses,$nsubtotal,$ntotal,$user_proses,$total_sementara,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			$tampil = mysqli_query($connect,"select * from soh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($tampil);
			$noso = $de['noso'];
			$tampil = mysqli_query($connect,"select * from sod where noso='$noso'");
     	while($k=mysqli_fetch_assoc($tampil)){
     		$qty = $k['qty'];
     		$id = $k['id'];
				$query = $connect->prepare("update sod set kurang=?,proses=? where id=?");
				$query->bind_param('isi',$qty,$proses,$id); 
				if($query->execute() and mysqli_affected_rows($connect)>0){}
			}
			?>
			<script>
				swal({title: "Data berhasil diproses", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal proses data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
				   }
				);
			</script>
			<?php
		}		
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$noso,$ppn)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from sod where noso='$noso'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>	
</body>