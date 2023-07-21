<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$query = mysqli_query($connect, "select * from soh where id=$_GET[id]");
		$de = mysqli_fetch_assoc($query);
		$noso = $de['noso'];
		// if ($de['batal']=='N') {
		// 	$batal = 'Y';
		// 	$query = $connect->prepare("update soh set batal=? where noso=?");
		// 	$query->bind_param('ss',$batal,$noso);
		// }else{
		// 	$batal = 'N';
		// 	$query = $connect->prepare("update soh set batal=? where noso=?");
		// 	$query->bind_param('ss',$batal,$noso);
		// }
		$query = $connect->prepare("delete from sod where noso=?");
		$query->bind_param('s',$noso);
		if($query->execute() and mysqli_affected_rows($connect)>0){
		}

		$query = $connect->prepare("delete from soh where id=?");
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
