<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$query=mysqli_query($connect,"select nobeli from belid where id='$_GET[id]'");
		$k = mysqli_fetch_assoc($query);
		$nobeli=$k['nobeli'];
		$query = $connect->prepare("delete from belid where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=wo';
				   }
				);
			</script>
			<?php
			$query = mysqli_query($connect,"select sum(subtotal) as nsubtotal from belid where nobeli='$nobeli'");
				$k = mysqli_fetch_assoc($query);
				$subtotal = $k['nsubtotal'];
				mysqli_query($connect,"update belih set subtotal='$subtotal', total=total_sementara+materai+(total_sementara*(ppn/100)) where nobeli='$nobeli'");			
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
