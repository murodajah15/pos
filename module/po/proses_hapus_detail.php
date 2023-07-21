<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select nopo from pod where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nopo = $de['nopo'];
		$query = $connect->prepare("delete from pod where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
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
			$query->bind_param('iiis',$nsubtotal,$ntotal,$total_sementara,$nopo);
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
