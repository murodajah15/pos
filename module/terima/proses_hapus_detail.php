<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select noterima from terimad where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$noterima = $de['noterima'];
		$query = $connect->prepare("delete from terimad where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			$tampil = mysqli_query($connect,"select * from terimah where noterima='$noterima'");
			$de = mysqli_fetch_assoc($tampil);
			$noterima = $de['noterima'];
			$nsubtotal=hit_total($connect,$noterima);
			$biaya_lain = $de['biaya_lain'];
			$ntotal = $nsubtotal + $biaya_lain;
			$query = $connect->prepare("update terimah set subtotal=?,total=? where noterima=?");
			$query->bind_param('iis',$nsubtotal,$ntotal,$noterima);
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
	function hit_total($connect,$noterima)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from terimad where noterima='$noterima'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>
		
</body>
