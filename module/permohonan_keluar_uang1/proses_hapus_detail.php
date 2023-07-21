<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select nomohon from mohklruangd where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nomohon = $de['nomohon'];
		$query = $connect->prepare("delete from mohklruangd where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			$tampil = mysqli_query($connect,"select * from mohklruangh where nomohon='$nomohon'");
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
