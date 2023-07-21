<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select nokwitansi from kasir_tagihand where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nokwitansi = $de['nokwitansi'];
		$query = $connect->prepare("delete from kasir_tagihand where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			$tampil = mysqli_query($connect,"select * from kasir_tagihan where nokwitansi='$nokwitansi'");
			$de = mysqli_fetch_assoc($tampil);
			$nokwitansi = $de['nokwitansi'];
			$materai = $de['materai'];
			$ntotal=hit_total($connect,$nokwitansi);
			$ntotal = $nsubtotal + $materai;
			$query = $connect->prepare("update kasir_tagihan set subtotal=?,total=? where nokwitansi=?");
			$query->bind_param('iis',$nsubtotal,$ntotal,$nokwitansi);
			if($query->execute() and mysqli_affected_rows($connect)>0){
			}
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=wo';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=wo';
				   }
				);
			</script>
			<?php
		}		
		//header("location:../../dashboard.php?m=wo");	
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
