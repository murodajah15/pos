<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select nokeluar from keluard where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nokeluar = $de['nokeluar'];
		$query = $connect->prepare("delete from keluard where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			$tampil = mysqli_query($connect,"select * from keluarh where nokeluar='$nokeluar'");
			$de = mysqli_fetch_assoc($tampil);
			$nokeluar = $de['nokeluar'];
			$nsubtotal=hit_total($connect,$nokeluar);
			$biaya_lain = $de['biaya_lain'];
			$ntotal = $nsubtotal + $biaya_lain;
			$query = $connect->prepare("update keluarh set subtotal=?,total=? where nokeluar=?");
			$query->bind_param('iis',$nsubtotal,$ntotal,$nokeluar);
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
	function hit_total($connect,$nokeluar)
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
	</script>
		
</body>
