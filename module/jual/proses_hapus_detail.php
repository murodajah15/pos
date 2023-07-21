<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$query=mysqli_query($connect,"select nojual from juald where id='$_GET[id]'");
		$k = mysqli_fetch_assoc($query);
		$nojual=$k['nojual'];
		$query = $connect->prepare("delete from juald where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			$query = mysqli_query($connect,"select sum(subtotal) as nsubtotal from juald where nojual='$nojual'");
			$k = mysqli_fetch_assoc($query);
			$subtotal = $k['nsubtotal'];
			$query=mysqli_query($connect,"select * from jualh where nojual='$nojual'");
			$k = mysqli_fetch_assoc($query);
			$total_sementara = $subtotal + $k['biaya_lain'] + $k['materai'];
			$total = $subtotal + $k['biaya_lain'] + $k['materai'] + ($k['total_sementara']*($k['ppn']/100));
			echo $total;
			mysqli_query($connect,"update jualh set subtotal='$subtotal',total_sementara='$total_sementara',total='$total' where nojual='$nojual'");			
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
</body>
