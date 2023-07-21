<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$query=mysqli_query($connect,"select nokwitansi from kasir_keluard where id='$_GET[id]'");
		$k = mysqli_fetch_assoc($query);
		$nokwitansi=$k['nokwitansi'];
		$query = $connect->prepare("delete from kasir_keluard where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";
			$query = mysqli_query($connect,"select sum(uang) as nsubtotal from kasir_keluard where nokwitansi='$nokwitansi'");
			$k = mysqli_fetch_assoc($query);
			$subtotal = $k['nsubtotal'];
			mysqli_query($connect,"update kasir_keluarh set subtotal='$subtotal', total='$subtotal'+materai where nokwitansi='$nokwitansi'");			
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
